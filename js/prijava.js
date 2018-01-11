$(document).ready(function() {
    "use strict"

    $.ajax({
        url: "kolacic.php",
        type: "POST",

        success: function (data) {
            var poruka = JSON.parse(data);
            $("#korisnicko_ime").val(poruka['poruka']);

        }
    });

});