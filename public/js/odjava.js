$(document).ready(function () {
    "use strict";

    $("#odjava").click(function (event) {

        $.ajax({
            url: "src/prijava/odjava.php",
            type: "POST",

            success: function (data) {
                window.location.replace('http://localhost:8000/kino/index.php');
            }
        });
    });


});