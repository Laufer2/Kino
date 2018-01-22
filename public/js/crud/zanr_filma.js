$(document).ready(function(){
    "use strict";
    var tablice = ["zanr","film"];

    $.ajax({
        url: "src/crud/zanr_filma.php",
        type: "POST",
        data:{
            tablica : tablice,
            aktivna_stranica : 0,
            akcija : 10
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
            $("#search").html(search(5));

        }
    });

    function search(akcija){
        var prikaz_searcha = "<form method='post' action='src/crud/zanr_filma.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
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
        prikaz_tablice += "Film";
        prikaz_tablice += "<button class='silazno' data-stupac='f.naziv_film'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='f.naziv_film'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Zanr";
        prikaz_tablice += "<button class='silazno' data-stupac='z2.naziv_zanr'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='z2.naziv_zanr'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Funkcije</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, vrijednost) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ vrijednost.film +"</td>"
            prikaz_tablice += "<td>"+ vrijednost.zanr +"</td>";

            prikaz_tablice += "<td>";
            prikaz_tablice += "<button class='gumb-delete' data-idf='"+ vrijednost.idf +"' data-idz='"+ vrijednost.idz +"'>Izbriši</button>";
            prikaz_tablice += "</td>";
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_formu(lista, akcija) {
        var prikaz_forme = "<form action='src/crud/zanr_filma.php' ";
        prikaz_forme += "id='novi_zapis' method='post' enctype='application/x-www-form-urlencoded'>";

        prikaz_forme += "<label for='film'>Film</label>";

        prikaz_forme += "<select name='film' id='film'>";
        $.each(lista.film, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='zanr'>Zanr</label>";

        prikaz_forme += "<select name='zanr' id='zanr'>";
        $.each(lista.zanr, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<input type='hidden' name='tablica' value='"+ tablice +"'>";
        prikaz_forme += "<input type='hidden' name='akcija' value='"+ akcija +"'>";

        prikaz_forme += "<input type='submit' value='Dodaj'>";
        prikaz_forme += "</form>";

        return prikaz_forme;
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

    function sort(tip_sorta, stupac){
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }

        $.ajax({
            url: 'src/crud/zanr_filma.php',
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
                $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta, data.stupac));
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
                $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica,"",""));

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
            url: "src/crud/zanr_filma.php",
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

    //kasno kreiranje elementa pa se mora koristiti ovaj način selektiranja elemenata
    $(document).on('click', '#gumb-kreiraj', function() {

        $.ajax({
            url : 'src/crud/zanr_filma.php',
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
        var idz = $(this).attr("data-idz");
        var idf = $(this).attr("data-idf");
        $("#dialog-potvrda").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Izbriši zapis": function() {
                    //brisanje i refresh tablice

                    $.ajax({
                        url: 'src/crud/zanr_filma.php',
                        type: 'POST',
                        data: {
                            tablica : tablice,
                            idz : idz,
                            idf : idf,
                            akcija : 3
                        },

                        success: function (data) {
                            data = JSON.parse(data);
                            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                            $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica, "",""));
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

                $("#paginacija").html(paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
                $("#search").html(search(5));
            }
        });

    });

});