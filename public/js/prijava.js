$(document).ready(function() {
    "use strict"

    $.ajax({
        url: "src/prijava/kolacic.php",
        type: "POST",

        success: function (data) {
            var poruka = JSON.parse(data);
            $("#korisnicko_ime").val(poruka['poruka']);

        }
    });

    $("#prijava").submit(function (event) {

        var forma = $("#prijava");
        event.preventDefault();
        $("#poruke").html("Prijava...");

        $.ajax({
            url: "src/prijava/prijava_obrada.php",
            type: "POST",
            datatype: "json",
            data: forma.serialize(),

            success: function (data) {
                var poruka = JSON.parse(data);
                if(poruka['redirect'] === 0){
                    $("#poruke").html(poruka['poruka']);
                }else{
                    window.location.replace(decodeURIComponent(poruka.redirect));
                }
            }

        });
    });

    $("#nova_lozinka").hide();

    $("#zaboravljena-lozinka").click(function () {

        $("#nova_lozinka").toggle(500);
    });

    $("#nova_lozinka").submit(function (event) {

        var forma = $("#nova_lozinka");
        event.preventDefault();

        $("#poruke").html("Slanje e-maila...");

        $.ajax({
            url: "src/prijava/zaboravljena_lozinka.php",
            type: "POST",
            datatype: "json",
            data: forma.serialize(),

            success: function (data) {
                var poruka = JSON.parse(data);
                $("#poruke").html(poruka['poruka']);
            }


        });

    });

});