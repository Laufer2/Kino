$( document ).ready( function() {

    "use strict";

    var polje_validacija = [0,0,0,0,0,0,0];
    var vazeci_email= false;

    function required(){
        var id = "";

        $("input").each( function() {
            id = $(this).attr('id') + "_poruka";
            if($(this).val().length === 0){
                $("#"+id).html("Obavezno polje.");
            }
        });
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
                $("#korisnicko_ime_poruka").html("Min 4 znaka u korisničkom imenu.");
            } else {
                polje_validacija[2] = 1;

                $.ajax({
                    type: "GET",
                    datatype: "JSON",
                    url: "src/registracija/registracija_ajax_provjera.php",
                    data: {
                        'korisnicko_ime': $(this).val()
                    },
                    success: function (data) {
                        var polje = JSON.parse(data);
                        if (polje["broj_redova"] > 0) {
                            $("#korisnicko_ime_poruka").html("Zauzeto korisničko ime.");
                            polje_validacija[1] = 0;
                        } else {
                            $("#korisnicko_ime_poruka").html("OK");
                            polje_validacija[1] = 1;
                        }
                    },
                    error: function () {
                        $("#korisnicko_ime_poruka").html("Greška prilikom provjere korisničkog imena.");
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
                $("#email_poruka").html("Nevažeća struktura e-mail adrese.");
                vazeci_email = false;
            }else{
                polje_validacija[0] = 1;
                $("#email_poruka").html("");
                vazeci_email = true;
            }
            if(vazeci_email){
                $.ajax({
                    type: "GET",
                    datatype: "JSON",
                    url: "src/registracija/registracija_ajax_provjera.php",
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
        }

    });


    $("#registracija").submit( function(event) {

        required();
        var forma = $("#registracija");

        var lozinka = $("#lozinka").val();
        var ponovljena_lozinka = $("#ponovo_lozinka").val();
        var regex2 = /.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/;



        if(lozinka.length < 8 ){
            polje_validacija[3] = 0;
            $("#lozinka_poruka").html("Lozinka mora biti duza od 7 znakova.");

        }else{
            polje_validacija[3] = 1;
            if(regex2.test(lozinka)){
                polje_validacija[4] = 1;
                if (lozinka !== ponovljena_lozinka){
                    polje_validacija[5] = 0;
                    $("#ponovo_lozinka_poruka").html("Lozinke nisu jednake.");
                }else{
                    polje_validacija[5] = 1;
                    $("#ponovo_lozinka_poruka").html("");
                }
                $("#lozinka_poruka").html("");
            }else{
                polje_validacija[4] = 0;
                $("#lozinka_poruka").html("Lozinka mora minimalno sadržavati 1 malo, 1 veliko slovo i 1 broj.");
            }
        }

        /*
        var kok = "";
        $("#greske2").html("");
        for (var i=0; i<polje_validacija.length;i++){
            kok += polje_validacija[i];
        }
        $("#greske2").html(kok);*/

        event.preventDefault();
        if(!funkcija.validacija(polje_validacija)){
            return false;
        }else{
            $("#greske").html("Registracija u tijeku...");
            $.ajax({
                type: "POST",
                url: "src/registracija/registracija_obrada.php",
                data: forma.serialize(),


                success: function (data) {
                    var polje = JSON.parse(data);
                    $("#greske").html(polje['poruka']);
                }
            });
        }
    });
});