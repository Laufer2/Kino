$(document).ready( function () {
    "use strict";

    $.ajax({
        url: "src/naslovnica/naslovnica_prijavljeni.php",
        type: "POST",
        data: {
            izbornik : 1,
            tablica: "lokacija"
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#lokacije-naslovnica").html(padajuci_izbornik(data));
        }
    });

    function padajuci_izbornik(data){

        var padajuci = "<select id='lokacije'>";
        padajuci += "<option selected>Odaberite lokaciju...</option>";

        $.each(data.lokacije, function (index, value) {
            padajuci += "<option value='"+ value.id +"'>"+ value.naziv +"</option>";
        });

        padajuci += "</select>";

        return padajuci;
    }

    function tablica(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Film";
        prikaz_tablice += "<button class='silazno' data-stupac='naziv_film'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='naziv_film'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Redatelj</th>";
        prikaz_tablice += "<th>Žanr</th>";
        prikaz_tablice += "<th>Trajanje</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Početak";
        prikaz_tablice += "<button class='silazno' data-stupac='dostupan_do'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='dostupan_do'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "</tr>";

        $.each(data.projekcije, function (index, value) {

            prikaz_tablice += "<tr class='red-projekcija' data-id='"+ value.id +"' style='cursor: pointer'>";

            prikaz_tablice += "<td>"+ value.naziv +"</td>";

            prikaz_tablice += "<td>";
            $.each(value.redatelj, function (ind, val) {
                prikaz_tablice += "<span>"+ val +"&nbsp;</span>";
            });
            prikaz_tablice += "</td>";

            prikaz_tablice += "<td>";
            $.each(value.zanr, function (ind, val) {
                prikaz_tablice += "<span>"+ val +"&nbsp;</span>";
            });
            prikaz_tablice += "</td>";

            prikaz_tablice += "<td>"+ value.trajanje +"&nbsp;min</td>";
            prikaz_tablice += "<td>"+ value.pocetak +"</td>";

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
            url: "src/naslovnica/naslovnica_prijavljeni.php",
            type: 'POST',
            data : {
                stupac : stupac,
                tip_sorta : tip_sorta,
                pojam : pojam,
                akcija : akcija,
                id : $("#lokacije").val()
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(tablica(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta, data.stupac));
            }
        });
    }

    function search(akcija, id){
        var prikaz_searcha = "<form method='post' action='src/naslovnica/naslovnica_prijavljeni.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='hidden' name='id' value='"+ id +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "src/naslovnica/naslovnica_prijavljeni.php",
            type: "POST",
            data: {
                aktivna_stranica: $(this).attr("data-stranica"),
                tip_sorta: $(this).attr("data-tip_sorta"),
                stupac: $(this).attr("data-stupac"),
                pojam: pojam,
                akcija: akcija,
                id: $("#lokacije").val()
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(tablica(data));
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
                $("#prikaz-tablice").html(tablica(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));

                if(data.poruka['poruka']){
                    $("#test").html("Nema podataka.");

                }
                $("#forma").html("");
            }
        });
    });

    $(document).on('click', '.red-projekcija', function () {
        document.location.href = "projekcija.php?id=" + $(this).attr("data-id");
    });

    $(document).on('change','#lokacije', function () {
        var id = $("#lokacije").val();
        $.ajax({
            url : "src/naslovnica/naslovnica_prijavljeni.php",
            type : "POST",
            data : {
                id : id
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(tablica(data));
                $("#search").html(search(5,id ));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
            }
        });
    });
});