$( document ).ready( function() {

    "use strict";

    var polje_validacija = [0,0,0,0,0,0,0];

    function required(){
        var id = "";

        $("input").each( function() {
            id = $(this).attr('id') + "_poruka";
            if($(this).val().length === 0){
                $("#"+id).html("Obavezno polje.");
            }
        });
    }

    function validacija() {
        required();
        for ( var i = 0; i < polje_validacija.length; i++){
            if(polje_validacija[i] === 0){
                return false;
            }
        }
        return true;
    }

    $("#ime").blur(function () {
        $("#ime_poruka").html("");
    });

    $("#prezime").blur(function () {
        $("#prezime_poruka").html("");
    });


    $("#korisnicko_ime").blur( function() {

        if($(this).val().length !== 0){
            if ($(this).val().length < 4) {
                polje_validacija[2] = 0;
                $("#korisnicko_ime_poruka").html("Min 4 znaka u korisnickom imenu.");
            } else {
                polje_validacija[2] = 1;

                $.ajax({
                    type: "GET",
                    datatype: "JSON",
                    url: "registracija_ajax_provjera.php",
                    data: {
                        'korisnicko_ime': $(this).val()
                    },
                    success: function (data) {
                        var polje = JSON.parse(data);
                        if (polje["broj_redova"] > 0) {
                            $("#korisnicko_ime_poruka").html("Zauzeto korisnicko ime.");
                            polje_validacija[1] = 0;
                        } else {
                            $("#korisnicko_ime_poruka").html("OK");
                            polje_validacija[1] = 1;
                        }
                    },
                    error: function () {
                        $("#korisnicko_ime_poruka").html("Greska prilikom provjere korisnickog imena.");
                        $("input[type='submit']").css("display", "none");
                    }
                });
            }
        }
    });

    $("#email").blur(function () {
        if($(this).val().length !== 0) {
            var email = $("#email").val();
            //preuzeto s emailregex.com
            var regex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if(!regex.test(email)){
                polje_validacija[0] = 0;
                $("#email_poruka").html("Nevazeca struktura e-mail adrese.");
            }else{
                polje_validacija[0] = 1;
                $("#email_poruka").html("");
            }

            $.ajax({
                type: "GET",
                datatype: "JSON",
                url: "registracija_ajax_provjera.php",
                data: {
                    'email': $(this).val()
                },
                success: function (data) {
                    var polje = JSON.parse(data);
                    if (polje["broj_redova"] > 0) {
                        $("#email_poruka").html("Postoji korisnik s tom e-mail adresom");
                        polje_validacija[6] = 0;
                    } else {
                        $("#email_poruka").html("");
                        polje_validacija[6] = 1;
                    }
                },
                error: function () {
                    $("#email_poruka").html("Greska prilikom provjere korisnickog imena.");
                    $("input[type='submit']").css("display", "none");
                }
            });
        }

    });


    $("#registracija").submit( function(event) {

        if(validacija()){
            event.preventDefault();
        }

        var lozinka = $("#lozinka").val();
        var ponovljena_lozinka = $("#ponovo_lozinka").val();
        var regex2 = "";

        polje_validacija[4] = 1;
        /* Ugnijezditi s prvim ifom
        if(regex2.test(lozinka)){
            polje_validacija[4] = 1;
            $("#lozinka_poruka").html("");
        }else{
            polje_validacija[4] = 0;
            $("#lozinka_poruka").html("Lozinka mora sadržavati 1 veliko slovo i 1 broj.");
            //dijakritički znakovi????
        }*/

        if(lozinka.length < 8 ){
            polje_validacija[3] = 0;
            $("#lozinka_poruka").html("Lozinka mora biti duza od 7 znakova.");
        }else{
            polje_validacija[3] = 1;
            $("#lozinka_poruka").html("");
            if (lozinka !== ponovljena_lozinka){
                polje_validacija[5] = 0;
                $("#ponovo_lozinka_poruka").html("Lozinke nisu jednake.");
            }else{
                polje_validacija[5] = 1;
                $("#ponovo_lozinka_poruka").html("");
            }
        }
        /*
        var kok = "";
        $("#greske").html("");
        for (var i=0; i<polje_validacija.length;i++){
            kok += polje_validacija[i];
        }
        $("#greske").html(kok); */

        var forma = $("#registracija");
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "registracija_obrada.php",
            data: forma.serialize(),


            success: function (data) {
                var polje = JSON.parse(data);
                $("#greske").html(polje['poruka']);
            }
        });
    });
});