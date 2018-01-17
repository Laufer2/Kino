$(document).ready(function () {
    "use strict";

    function nacrtaj_tablicu(data) {

        var prikaz_lokacija = "<table class='tablica'>";
        prikaz_lokacija += "<tr>";
        prikaz_lokacija += "<th>Lokacija</th>";
        prikaz_lokacija += "<th>Ulica</th>";
        prikaz_lokacija += "<th>Broj</th>";
        prikaz_lokacija += "<th>Grad</th>";
        prikaz_lokacija += "<th>Drzava</th>";
        prikaz_lokacija += "<th>Funkcije</th>";
        prikaz_lokacija += "</tr>";

        $.each(data.podaci, function (index, vrijednost) {

            prikaz_lokacija += "<tr>";
            prikaz_lokacija += "<td>"+ vrijednost["naziv_lokacije"] +"</td>";
            prikaz_lokacija += "<td>"+ vrijednost["ulica"] +"</td>";
            prikaz_lokacija += "<td>"+ vrijednost["broj"] +"</td>";
            prikaz_lokacija += "<td>"+ vrijednost["naziv_grada"] +"</td>";
            prikaz_lokacija += "<td>"+ vrijednost["naziv_drzave"] +"</td>";

            prikaz_lokacija += "<td>";
            prikaz_lokacija += "<button class='gumb-edit' data-id='"+ vrijednost.id_lokacija +"'>Uredi</button>";
            prikaz_lokacija += "<button class='gumb-delete' data-id='"+ vrijednost.id_lokacija +"'>Izbriši</button>";
            prikaz_lokacija += "</td>";
            prikaz_lokacija += "</tr>";

        });

        prikaz_lokacija += "</table>";

        return prikaz_lokacija;
    }

    $.ajax({
        url: 'src/lokacije/crud_lokacije.php',
        type: 'GET',

        success: function (data) {
            var prikaz = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(prikaz));
        }
    });

    $(".gumb").click(function () {
        $("#test").html("Kliknuto.");
    });

    $(document).on('click', '.gumb-delete', function(){
        $("#dialog-potvrde").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Izbriši zapis": function() {
                    $( this ).dialog( "close" );
                    //brisanje i refresh tablice
                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
});