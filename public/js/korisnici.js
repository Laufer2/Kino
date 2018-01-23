$(document).ready( function(){
    "use strict";

    $.ajax({
        url : '../src/privatno/korisnici.php',
        type : 'POST',
        data : {
            aktivna_stranica : 0,
            akcija : 10
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#search").html(search(5));
            $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
        }
    });

    function search(akcija){
        var prikaz_searcha = "<form method='post' action='../src/privatno/korisnici.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function paginacija(aktivna_stranica, broj_stranica, tip_sorta, stupac) {

        var paginacija = "";
        if(broj_stranica > 0) {

            var broj, pocetak = 0;

            paginacija = "<span class='jump-to-first broj-paginacija' style='cursor: pointer' " +
                "data-stranica='0' data-tip_sorta='" + tip_sorta + "' data-stupac='" + stupac + "'> |< &nbsp;</span>";

            if (aktivna_stranica > 2) {
                paginacija += "<span class='prednje'>&nbsp; ... &nbsp;</span>"; // na početku
            } else {
                $(".prednje").css("display: none;");
            }

            var max = aktivna_stranica + 3;
            if (max > broj_stranica) {
                max = broj_stranica;
            }

            if (aktivna_stranica < 3) {
                pocetak = 0;
            } else {
                pocetak = aktivna_stranica - 2;
            }

            for (var i = pocetak; i < max; i++) {
                broj = i + 1;
                if (i === aktivna_stranica) {
                    paginacija += "<span class='broj-paginacija' style='cursor: pointer; color: red' " +
                        "data-stranica='" + i + "' data-stupac='" + stupac + "' data-tip_sorta='" + tip_sorta + "'>" + broj + " </span>";
                    continue;
                }
                paginacija += "<span class='broj-paginacija' style='cursor: pointer' " +
                    "data-stranica='" + i + "' data-stupac='" + stupac + "' data-tip_sorta='" + tip_sorta + "'>" + broj + " </span>";
            }

            if ((aktivna_stranica + 3) < broj_stranica) {
                paginacija += "<span class='zadnje'>&nbsp; ... &nbsp;</span>"; // na kraju
            } else {
                $(".zadnje").css("display: none;");
            }

            var zadnja = broj_stranica - 1;
            paginacija += "<span class='jump-to-first broj-paginacija' style='cursor: pointer' " +
                "data-stranica='" + zadnja + "' data-stupac='" + stupac + "' data-tip_sorta='" + tip_sorta + "'>&nbsp;>| </span>";
        }
        return paginacija;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Korisničko ime";
        prikaz_tablice += "<button class='silazno' data-stupac='k.korisnicko_ime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.korisnicko_ime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Tip korisnika";
        prikaz_tablice += "<button class='silazno' data-stupac='t.naziv_tipkorisnika'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='t.naziv_tipkorisnika'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Ime</th>";
        prikaz_tablice += "<th>Prezime</th>";
        prikaz_tablice += "<th>E-mail</th>";
        prikaz_tablice += "<th>Lozinka</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, korisnik) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ korisnik.korisnicko +"</td>";
            prikaz_tablice += "<td>"+ korisnik.tipkorisnika +"</td>";
            prikaz_tablice += "<td>"+ korisnik.ime +"</td>";
            prikaz_tablice += "<td>"+ korisnik.prezime +"</td>";
            prikaz_tablice += "<td>"+ korisnik.email +"</td>";
            prikaz_tablice += "<td>"+ korisnik.lozinka +"</td>";


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
            url: '../src/privatno/korisnici.php',
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
                $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta, data.stupac));
            }
        });
    }

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "../src/privatno/korisnici.php",
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
                    $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta, data.stupac));
                }else{
                    $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
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
                $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica,"",""));

                if(data.poruka['poruka']){
                    $("#test").html("Nema podataka.");

                }
                $("#forma").html("");
            }
        });
    });

});