$(document).ready(function () {
    "use strict";

    $.ajax({

        url : "src/istek_sesije.php",
        method : "post",

        success : function (data) {
            var poruka = JSON.parse(data);
            if (poruka["redirect"] !== 0){
                window.location.replace(decodeURIComponent(poruka.redirect));
            }
        }
    });


    $("#odjava").click(function (event) {

        $.ajax({
            url: "src/prijava/odjava.php",
            type: "POST",

            success: function (data) {
                var poruka = JSON.parse(data);
                window.location.replace(decodeURIComponent(poruka.redirect));
            }
        });
    });
});