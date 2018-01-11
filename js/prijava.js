$(document).ready(function() {
    "use strict"

    $.ajax({
        url: "prijava.php",
        type: "GET",
        data:{
            'kolacic':1
        },

        success: function (data) {
            var korisnicko_ime = data['poruka'];
            if(korisnicko_ime !== "") {
                $("#korisnicko_ime").attr('value', korisnicko_ime);
            }
        }
    });


});