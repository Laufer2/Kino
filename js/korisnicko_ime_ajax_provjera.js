$( document ).ready(

    function () {

        "use strict";

        $("#korime").blur( function(){

            var korisnicko_ime = $("#korime").val();

            $.ajax({
                type: "GET",
                datatype: "JSON",
                url: "korisnicko_ime_ajax_provjera.php",
                data: {
                    'korisnicko_ime': korisnicko_ime
                },
                success: function (data) {
                    var polje = JSON.parse(data);
                    if(polje["broj_redova"] > 0){
                        $("#korime_poruka").html("Zauzeto korisnicko ime.");
                    }else{
                        $("#korime_poruka").html("OK");
                    }
                },
                error: function () {
                    $("#korime_poruka").html("Greska prilikom provjere korisnickog imena.");
                    $("input[type='submit']").css("display", "none");
                }
            });
        });
    }
);