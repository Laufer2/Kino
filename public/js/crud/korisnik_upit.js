$(document).ready(function(){
    "use strict";
    var tablice = ["korisnik","upit"];

    $.ajax({
        url: "src/crud/korisnik_upit.php",
        type: "POST",
        data:{
            tablica : tablice,
            aktivna_stranica : 0,
            akcija : 10
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
            $("#search").html(search(5));

        }
    });

    function search(akcija){
        var prikaz_searcha = "<form method='post' action='src/crud/korisnik_upit.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='tablica' value='"+tablice+"'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+akcija+"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<button id='gumb-kreiraj'>";
        prikaz_tablice += "Dodaj novi zapis";
        prikaz_tablice += "</button>";

        prikaz_tablice += "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Upiti";
        prikaz_tablice += "<button class='silazno' data-stupac='s.naziv_upit'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='s.naziv_upit'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Korisnik";
        prikaz_tablice += "<button class='silazno' data-stupac='k.korisnicko_ime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.korisnicko_ime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Vrijeme";
        prikaz_tablice += "<button class='silazno' data-stupac='vrijeme'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='vrijeme'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Funkcije</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, vrijednost) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ vrijednost.upit +"</td>";
            prikaz_tablice += "<td>"+ vrijednost.korisnik +"</td>";
            prikaz_tablice += "<td>"+ vrijednost.vrijeme +"</td>";

            prikaz_tablice += "<td>";
            prikaz_tablice += "<button class='gumb-delete' data-idk='"+ vrijednost.idk +"' data-idl='"+ vrijednost.idl +"' " +
                "data-vrijeme='"+ vrijednost.vrijeme2 +"'>Izbriši</button>";
            prikaz_tablice += "</td>";
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_formu(lista, akcija) {
        var prikaz_forme = "<form action='src/crud/korisnik_upit.php' ";
        prikaz_forme += "id='novi_zapis' method='post' enctype='application/x-www-form-urlencoded'>";

        prikaz_forme += "<label for='upit'>Lokacija </label>";

        prikaz_forme += "<select name='upit' id='upit'>";
        $.each(lista.upit, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });

        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='korisnik'>Korisnik </label>";

        prikaz_forme += "<select name='korisnik' id='korisnik'>";
        $.each(lista.korisnik, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label>Vrijeme</label><br/>";
        prikaz_forme += "<label for='datum1'>Datum</label>";
        prikaz_forme += "<input type='date' name='datum1' required>";
        prikaz_forme += "<label for='sati1'>Vrijeme</label>";
        prikaz_forme += "<input type='number' name='sati1' placeholder='sati' required><span>:</span>";
        prikaz_forme += "<input type='number' name='minute1' placeholder='min' required><br/>";

        prikaz_forme += "<input type='hidden' name='tablica' value='"+ tablice +"'>";
        prikaz_forme += "<input type='hidden' name='akcija' value='"+ akcija +"'>";

        prikaz_forme += "<input type='hidden' name='idl'>";
        prikaz_forme += "<input type='hidden' name='idk'>";

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
            url: 'src/crud/korisnik_upit.php',
            type: 'POST',
            data : {
                tablica : tablice,
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

    $(document).on('click', '.uzlazno', function () {
        sort('ASC', $(this).attr('data-stupac'));
    });

    $(document).on('click', '.silazno', function () {
        sort('DESC', $(this).attr('data-stupac'));
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
                }else{
                    $("#test").html("");
                }
                $("#forma").html("");
            }
        });
    });

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";

        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "src/crud/korisnik_upit.php",
            type: "POST",
            data: {
                aktivna_stranica: $(this).attr("data-upit"),
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

    //kasno kreiranje elementa pa se mora koristiti ovaj način selektiranja elemenata
    $(document).on('click', '#gumb-kreiraj', function() {

        $.ajax({
            url : 'src/crud/korisnik_upit.php',
            type : 'POST',
            data : {
                tablica : tablice,
                selectmenu : 1
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#forma").html( nacrtaj_formu(data, 1));
            }
        });

    });

    $(document).on('click', '.gumb-delete', function(){
        var idl = $(this).attr("data-idl");
        var idk = $(this).attr("data-idk");
        var vrijeme = $(this).attr("data-vrijeme");
        $("#dialog-potvrda").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Izbriši zapis": function() {
                    //brisanje i refresh tablice

                    $.ajax({
                        url: 'src/crud/korisnik_upit.php',
                        type: 'POST',
                        data: {
                            tablica : tablice,
                            idl : idl,
                            idk : idk,
                            vrijeme : vrijeme,
                            akcija : 3
                        },

                        success: function (data) {
                            data = JSON.parse(data);
                            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                            $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "",""));
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
                    $("#test").html("Taj zapis već postoji.");

                }else{
                    $("#test").html("");
                    $("#forma").html("");
                }

                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
                $("#search").html(search(5));
            }
        });

    });

});