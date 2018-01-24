$(document).ready( function () {
    "use strict";

    $.ajax({
        url: "src/naslovnica/naslovnica_neprijavljeni.php",
        type: "POST",
        data: {
            tablica: "lokacija"
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#lokacije-naslovnica").html(padajuci_izbornik(data));
        }
    });


}