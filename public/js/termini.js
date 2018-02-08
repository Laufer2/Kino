$(document).ready( function () {
    "use strict";

    $.ajax({
        url: "src/termini/termini.php",
        type: "POST",
        data: {
            selectmenu: 1
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#termini-lokacije").html(padajuci_izbornik(data.lokacije, "Lokacije"));
            $("#termini-filmovi").html(padajuci_izbornik(data.filmovi, "Film"));
        }
    });

    function padajuci_izbornik(data, tip){
        var padajuci = "<label>"+ tip +"&nbsp;</label><br/>";
        padajuci += "<select name='"+ tip +"' required>";
        padajuci += "<option selected>Odaberite...</option>";

        $.each(data, function (index, value) {
            padajuci += "<option value='"+ value.id +"'>"+ value.naziv +"</option>";
        });

        padajuci += "</select>";

        return padajuci;
    }


    $(document).on('submit', '#novi-termin', function (event) {

        event.preventDefault();

        $.ajax({
            url : "src/termini/termini.php",
            type : "POST",
            data : $(this).serialize(),

            success: function (data) {
                data = JSON.parse(data);
                $("#poruke").html(data.poruka).css("display","block").css("background-color", "#4CAF50");
            }
        });

    });


});