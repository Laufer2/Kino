$(document).ready( function () {
    "use strict";

    $("#novi_link").submit(function (event) {
        var forma = $("#novi_link");
        var email = $("#email").val();

        event.preventDefault();
        $("#poruke").html("Slanje u tijeku...");

        $.ajax({
            url: 'src/registracija/novi_akt_link.php',
            type: 'POST',
            data: forma.serialize(),

            success: function (data) {

                var json = JSON.parse(data);
                $("#poruke").html(json['poruka']);

            }
        });

    });

});