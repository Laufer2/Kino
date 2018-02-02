$(document).ready( function(){
    "use strict";

    $.ajax({
        url : 'src/slike/upload_slika.php',
        type : 'POST',
        data : {
            aktivna_stranica : 0,
            akcija : 10
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#search").html(search(5));
            $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
        }
    });

    function search(akcija){
        var prikaz_searcha = "<form method='post' action='src/slike/upload_slika.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Film";
        prikaz_tablice += "<button class='silazno' data-stupac='f.naziv_film'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='f.naziv_film'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Vrijeme</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Lokacija";
        prikaz_tablice += "<button class='silazno' data-stupac='l.naziv_lokacija'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='l.naziv_lokacija'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Broj rezervacija</th>";
        prikaz_tablice += "<th>Dodaj sliku</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, rezervacija) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ rezervacija.film +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.vrijeme +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.lokacija +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.broj_rezervacija +"</td>";

            prikaz_tablice += "<td>";
            prikaz_tablice += "<button class='gumb-dodaj' data-id='"+ rezervacija.id +"'>Dodaj sliku</button>";
            prikaz_tablice += "</td>"

            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function sort(tip_sorta, stupac){
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }

        $.ajax({
            url: 'src/slike/upload_slika.php',
            type: 'POST',
            data : {
                stupac : stupac,
                tip_sorta : tip_sorta,
                pojam : pojam,
                akcija : akcija
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta, data.stupac));
            }
        });
    }

    function nacrtaj_formu(id) {

        var prikaz_forme = "<form action='src/slike/obrada_forme.php' ";
        prikaz_forme += "id='nova_slika' method='post' enctype='multipart/form-data'>";

        prikaz_forme += "<label for='slika'>Slika</label>";
        prikaz_forme += "<input type='file' name='slika' id='slika' accept='image/*' title='Možete uploadati samo slike' required><br/>";

        prikaz_forme += "<div id='tagovi'>";
        prikaz_forme += "<label>Tag</label>";
        prikaz_forme += "<input type='text' name='tag[]' required><button type='button' id='novi-tag'>+</button><br/>";
        prikaz_forme += "</div>";

        prikaz_forme += "<input type='hidden' name='id' value='"+ id +"'>";

        prikaz_forme += "<input type='submit' value='Dodaj'>";
        prikaz_forme += "</form>";

        return prikaz_forme;

    }

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "src/slike/upload_slika.php",
            type: "POST",
            data: {
                aktivna_stranica: $(this).attr("data-stranica"),
                tip_sorta: $(this).attr("data-tip_sorta"),
                stupac: $(this).attr("data-stupac"),
                pojam: pojam,
                akcija: akcija
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                if(data.stupac.length > 0){
                    $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta, data.stupac));
                }else{
                    $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
                }
            }
        });
    });

    $(document).on('click', '.uzlazno', function () {
        sort('ASC', $(this).attr("data-stupac"));
    });

    $(document).on('click', '.silazno', function () {
        sort('DESC', $(this).attr("data-stupac"));
    });

    $(document).on('click', '#novi-tag', function () {
        var tag = "<label>Tag</label>";
        tag += "<input type='text' name='tag[]'><br/>";
        $("#tagovi").append(tag);
    });

    $(document).on('click', '.gumb-dodaj', function() {
        $("#forma").html(nacrtaj_formu($(this).attr("data-id")));
    });

    $(document).on('submit', '#pretraga', function (event){

        var forma = $("#pretraga");
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data : forma.serialize(),

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));

                if(data.poruka['poruka']){
                    $("#test").html("Nema podataka.");

                }
                $("#forma").html("");
            }
        });
    });

    $(document).on('submit', '#nova_slika', function (event) {

        var forma = $("#pretraga");
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data : forma.serialize(),

            success: function (data) {
                data = JSON.parse(data);

            }
        });

    });

});