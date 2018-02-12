$(document).ready( function(){
    "use strict";

    $.ajax({
        url : 'src/rezervacije/rezervacije.php',
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
        var prikaz_searcha = "<form method='post' action='src/rezervacije/rezervacije.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
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
        prikaz_tablice += "Lokacija";
        prikaz_tablice += "<button class='silazno' data-stupac='l.naziv_lokacija'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='l.naziv_lokacija'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Film";
        prikaz_tablice += "<button class='silazno' data-stupac='f.naziv_film'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='f.naziv_film'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Vrijeme</th>";
        prikaz_tablice += "<th>Broj rezervacija</th>";
        prikaz_tablice += "<th>Status rezervacije</th>";
        prikaz_tablice += "<th>Slike</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, rezervacija) {

            prikaz_tablice += "<tr>";
                prikaz_tablice += "<td>"+ rezervacija.lokacija +"</td>";
                prikaz_tablice += "<td>"+ rezervacija.film +"</td>";
                prikaz_tablice += "<td>"+ rezervacija.pocetak +"</td>";
                prikaz_tablice += "<td>"+ rezervacija.broj_rezervacija +"</td>";
                prikaz_tablice += "<td>"+ rezervacija.status +"</td>";
                if(rezervacija.status === "Potvrđena"){
                    prikaz_tablice += "<td><a href='#forma'><button class='gumb-slika' data-id='"+ rezervacija.id +"'>Slika</button></a></td>";
                }else{
                    prikaz_tablice += "<td><button class='gumb-neslika' disabled>Slika</button></td>";
                }
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_formu(id){

        var prikaz_forme = "<form action='src/slike/obrada_forme.php' ";
        prikaz_forme += "id='upload_slike' method='post' enctype='multipart/form-data'>";

        prikaz_forme += "<label>Slika&nbsp;</label>";
        prikaz_forme += "<input type='file' name='slika' id='slika' accept='image/x-png,image/gif,image/jpeg' title='Dopuštene samo slike' required><br/>";
        prikaz_forme += "<label>Oznaka&nbsp;</label><br>";
        prikaz_forme += "<div id='oznaka'><input type='text' name='oznaka[]' id='oznaka'>";
        prikaz_forme += "<button type='button' class='gumb-plus' id='nova-oznaka'>+</button><br/></div>";

        prikaz_forme += "<input type='hidden' name='id' value='"+ id +"'>";

        prikaz_forme += "<input type='submit' value='Dodaj sliku'>";
        prikaz_forme += "</form>";

        return prikaz_forme;

    }

    function sort(tip_sorta, stupac){
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }

        $.ajax({
            url: 'src/rezervacije/rezervacije.php',
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

    $(document).on('click', '.gumb-slika', function () {
        $("#test").html("").css("display","none");
        $("#forma").html(nacrtaj_formu($(this).attr("data-id")));
    });

    $(document).on('click', '#nova-oznaka', function () {
        var oznaka = "<input type='text' name='oznaka[]'><br/>";
        $("#oznaka").append(oznaka);
    });

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "src/rezervacije/rezervacije.php",
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

    $(document).on('submit', '#upload_slike', function(event){

        event.preventDefault();

        var forma = $(this);
        var file = new FormData(forma[0]);

        event.preventDefault();

        $.ajax({
            url : $(this).attr("action"),
            type : $(this).attr("method"),
            data : file,
            cache: false,
            contentType: false,
            processData: false,

            success: function (data) {
                data = JSON.parse(data);
                $("#forma").html();
                if(data.poruka){
                    $("#test").html(data.poruka).css("display","block").css("background-color","#4CAF50");
                }
            }
        });
    });
});