$(document).ready( function () {
    "use strict";

    pocetna(0, 0, 1);

    function pocetna(lokacija, projekcija, padajuci) {
        $.ajax({
            url: "src/slike/korisnicke_slike.php",
            type: "POST",
            data: {
                padajuci : padajuci,
                lokacija : lokacija,
                projekcija : projekcija
            },

            success: function (data) {
                data = JSON.parse(data);
                if(data.lokacije){
                    $("#poruke").html("").css("display","none");
                    $("#termini-lokacije").html(padajuci_izbornik(data.lokacije, "Lokacija"));
                    $("#prikaz-tablice").html("");
                    $("#search").html("");

                }else if(data.projekcije){
                    $("#poruke").html("").css("display","none");
                    $("#termini-filmovi").html(padajuci_izbornik(data.projekcije, "Projekcija"));

                }else{
                    if(parseInt(data.poruka)){
                        $("#poruke").html("Nema podataka.").css("display","block");

                        $("#prikaz-tablice").html("");
                        $("#search").html("");
                    }else{
                        $("#poruke").html("").css("display","none");
                        $("#search").html(search(5, projekcija));
                        $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                        $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
                    }
                }
            }
        });
    }

    function padajuci_izbornik(data, tip) {
        var padajuci = "<select name='" + tip + "' required>";
        padajuci += "<option value='-1'>"+tip+"...</option>";

        $.each(data, function (index, value) {
            padajuci += "<option value='" + value.id + "'>" + value.naziv + "</option>";
        });

        padajuci += "</select>";

        return padajuci;
    }

    function search(akcija, projekcija){
        var prikaz_searcha = "<form method='post' action='src/slike/korisnicke_slike.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='hidden' name='projekcija' value='"+ projekcija +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Ime";
        prikaz_tablice += "<button class='silazno' data-stupac='k.ime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.ime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Prezime";
        prikaz_tablice += "<button class='silazno' data-stupac='k.prezime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.prezime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, korisnik) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ korisnik.ime +"</td>";
            prikaz_tablice += "<td>"+ korisnik.prezime +"</td>";
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
            url: 'src/slike/korisnicke_slike.php',
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

    $(document).on('change', '#termini-lokacije', function () {
        pocetna($('select[name=Lokacija]').val(), 0, 2);
    });

    $(document).on('change', '#termini-filmovi', function () {
        pocetna($('select[name=Lokacija]').val(), $('select[name=Projekcija]').val());
    });

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "src/slike/korisnicke_slike.php",
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
        $("#poruke").html("").css("display","none");
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data : forma.serialize(),

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));

                if(data.poruka['poruka']){
                    $("#poruke").html("Nema podataka.").css("display","block");

                }
                $("#forma").html("");
            }
        });
    });
});