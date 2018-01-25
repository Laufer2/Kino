$(document).ready( function () {
    "use strict";

    $.ajax({
        url : "src/naslovnica/naslovnica_neprijavljeni.php",
        type : "POST",
        data : {
            tablica : "lokacija"
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
        prikaz_tablice += "<th>Film</th>";
        prikaz_tablice += "<th>Redatelj</th>";
        prikaz_tablice += "<th>Žanr</th>";
        prikaz_tablice += "<th>Trajanje</th>";
        prikaz_tablice += "<th>Početak</th>";
        prikaz_tablice += "</tr>";

        $.each(data.projekcije, function (index, value) {

            prikaz_tablice += "<tr>";

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

    $(document).on('change','#lokacije', function () {

        $.ajax({
            url : "src/naslovnica/naslovnica_neprijavljeni.php",
            type : "POST",
            data : {
                id : $(this).val()
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#projekcije-naslovnica").html(tablica(data));
            }


        });

    });

});