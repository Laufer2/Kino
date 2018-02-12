$(document).ready(function(){
    "use strict";

    $.ajax({
        url: "src/crud/film.php",
        type: "GET",
        data:{
            aktivna_stranica : 0,
            akcija : 10
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, ""));
            $("#search").html(search(5));

        }
    });

    function search(akcija){
        var tablica = funkcija.getUrlVariable("tablica");
        var prikaz_searcha = "<form method='get' action='src/crud/film.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='tablica' value='"+tablica+"'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+akcija+"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<a href='#forma'><button id='gumb-kreiraj'>";
        prikaz_tablice += "Dodaj novi zapis";
        prikaz_tablice += "</button></a>";

        prikaz_tablice += "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>Id</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Film";
        prikaz_tablice += "<button class='silazno' data-stupac='naziv_film'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='naziv_film'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Godina</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Trajanje";
        prikaz_tablice += "<button class='silazno' data-stupac='trajanje'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='trajanje'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Sadržaj</th>";
        prikaz_tablice += "<th>Funkcije</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, vrijednost) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ vrijednost.id +"</td>"
            prikaz_tablice += "<td>"+ vrijednost.naziv +"</td>";
            prikaz_tablice += "<td>"+ vrijednost.godina +"</td>";
            prikaz_tablice += "<td>"+ vrijednost.trajanje +"</td>";
            prikaz_tablice += "<td>"+ vrijednost.sadrzaj +"</td>";

            prikaz_tablice += "<td>";
            prikaz_tablice += "<a href='#forma'><button class='gumb-edit' data-id='"+ vrijednost.id +"'>Uredi</button></a>";
            prikaz_tablice += "<button class='gumb-delete' data-id='"+ vrijednost.id +"'>Izbriši</button>";
            prikaz_tablice += "</td>";
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_formu(akcija, id) {
        var prikaz_forme = "<form action='src/crud/film.php' ";
        prikaz_forme += "id='novi_zapis' method='get' enctype='application/x-www-form-urlencoded'>";

        prikaz_forme += "<label for='naziv'>Film</label><br>";
        prikaz_forme += "<input type='text' name='naziv' id='naziv' required><br/>";

        prikaz_forme += "<label for='godina'>Godina</label><br>";
        prikaz_forme += "<input type='number' name='godina' id='godina' required><br/>";

        prikaz_forme += "<label for='trajanje'>Trajanje</label><br>";
        prikaz_forme += "<input type='number' name='trajanje' id='trajanje' required><br/>";

        prikaz_forme += "<label for='sadrzaj'>Sadržaj</label><br>";
        prikaz_forme += "<textarea cols='20' rows='3' name='sadrzaj' id='sadrzaj' required></textarea><br/>";

        prikaz_forme += "<input type='hidden' name='akcija' value='"+akcija+"'>";
        prikaz_forme += "<input type='hidden' name='id' value='"+id+"'>";

        prikaz_forme += "<input type='submit' value='Dodaj'>";
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
            url: 'src/crud/film.php',
            type: 'GET',
            data : {
                stupac : stupac,
                tip_sorta : tip_sorta,
                pojam : pojam,
                akcija : akcija
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta));
            }
        });
    }

    $(document).on('click', '.uzlazno', function () {
        sort('ASC', $(this).attr("data-stupac"));
    });

    $(document).on('click', '.silazno', function () {
        sort('DESC',$(this).attr("data-stupac"));
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
                    $("#test").html("Nema podataka.").css("display","block");
                }else{
                    $("#test").css("display","none");
                }
                $("#forma").html("");
            }
        });
    });

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";
        var tablica = funkcija.getUrlVariable("tablica");
        var stupac = "naziv_"+ tablica;

        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "src/crud/film.php",
            type: "GET",
            data: {
                tablica : tablica,
                aktivna_stranica: $(this).attr("data-stranica"),
                tip_sorta: $(this).attr("data-tip_sorta"),
                stupac: stupac,
                pojam: pojam,
                akcija: akcija
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                if(data.stupac.length > 0){
                    $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta));
                }else{
                    $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, ""));
                }
            }
        });
    });

    //kasno kreiranje elementa pa se mora koristiti ovaj način selektiranja elemenata
    $(document).on('click', '#gumb-kreiraj', function() {

        var forma = nacrtaj_formu(2,0);
        $("#forma").html(forma);

    });

    $(document).on('click', '.gumb-edit', function() {
        var id = $(this).attr("data-id");
        $.ajax({
            url: 'src/crud/film.php',
            type: 'GET',
            data: {
                id: id,
                akcija: 3
            },

            success: function (data) {
                var prikaz = JSON.parse(data);
                var forma = nacrtaj_formu(4, prikaz['id']);

                $("#forma").html(forma);
                $("#naziv").val(prikaz['naziv']);
                $("#trajanje").val(prikaz['trajanje']);
                $("#sadrzaj").val(prikaz['sadrzaj']);
                $("#godina").val(prikaz['godina']);

            }
        });
    });

    $(document).on('click', '.gumb-delete', function(){
        var id = $(this).attr("data-id");
        $("#dialog-potvrda").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Izbriši zapis": function() {
                    //brisanje i refresh tablice

                    $.ajax({
                        url: 'src/crud/film.php',
                        type: 'GET',
                        data: {
                            id : id,
                            akcija : 1
                        },

                        success: function (data) {
                            data = JSON.parse(data);
                            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                            $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, ""));
                            $("#search").html(search(5));
                        }
                    });

                    $( this ).dialog( "close" );

                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });

    //kod zaustavljanja redirecta, podaci iz forme se moraju poslati preko data varijable u ajax-u
    $(document).on('submit', '#novi_zapis', function(event) {

        var forma = $("#novi_zapis");
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data : forma.serialize(),

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));

                if(data.poruka['poruka']){
                    $("#test").html("Zapis s tim imenom već postoji.").css("display","block");

                }else{
                    $("#test").css("display","none");
                    $("#forma").html("");
                }

                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,""));
                $("#search").html(search(5));
            }
        });
    });
});