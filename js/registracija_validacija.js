$( document ).ready( function() {

    "use strict";

    var polje_validacija = [0,0,0,0,0,0];

    function required(){
        var id = "";

        $("input").each( function() {
            id = $(this).attr('id') + "_poruka";
            if($(this).val().length === 0){
                $("#"+id).html("Obavezno polje.");
                return false;
            }else{
                $("#"+id).html("");
            }
            return true;
        });
    }

    function validacija() {
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

    $("#korime").blur( function(){

        var korisnicko_ime = $(this).val();

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
                    polje_validacija[0] = 0;
                }else{
                    $("#korime_poruka").html("OK");
                    polje_validacija[0] = 1;
                }
            },
            error: function () {
                $("#korime_poruka").html("Greska prilikom provjere korisnickog imena.");
                $("input[type='submit']").css("display", "none");
            }
        });
    });

    $("#email").blur( function(){

        var email = $(this).val();
        //preuzeto s emailregex.com
        var regex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if(!regex.test(email) && $(this).val().length !== 0){
            polje_validacija[1] = 0;
            $("#email_poruka").html("Nevazeca struktura e-mail adrese.");
        }else{
            polje_validacija[1] = 1;
            $("#email_poruka").html("");
        }
    });

    //minimalna duzina - 4 znaka
    $("#korisnicko_ime").blur( function() {
        if($(this).val().length < 4 && $(this).val().length !== 0){
            polje_validacija[2] = 0;
            $("#korisnicko_ime_poruka").html("Min 4 znaka u korisnickom imenu.");
        }else{
            polje_validacija[2] = 1;
            $("#korisnicko_ime_poruka").html("");
        }
    });

    //minimalna duzina - 8 znakova
    //min 1 veliko slovo i 1 broj
    $("#lozinka").blur(function() {

        var lozinka = $("#lozinka").val();
        var regex = "";

        if($(this).val().length < 8 && $(this).val().length !== 0){
            polje_validacija[3] = 0;
            $("#lozinka_poruka").html("Lozinka mora biti duza od 7 znakova.");
        }else{
            polje_validacija[3] = 1;
            $("#lozinka_poruka").html("");
        }

        if(regex.test(lozinka)){
            polje_validacija[4] = 1;
            $("#lozinka_poruka").html("");
        }else{
            polje_validacija[4] = 0;
            $("#lozinka_poruka").html("Lozinka mora sadržavati 1 veliko slovo i 1 broj.");
            //dijakritički znakovi????
        }
    });

    $("#ponovo_lozinka").blur(function() {

        var original_lozinka = $("#lozinka").val();
        var ponovljena_lozinka = $("#ponovo_lozinka").val();

        if (original_lozinka !== ponovljena_lozinka && $(this).val().length !== 0){
            polje_validacija[5] = 0;
            $("#ponovo_lozinka_poruka").html("Lozinke nisu jednake.");
        }else{
            polje_validacija[5] = 1;
            $("#ponovo_lozinka_poruka").html("");
        }
    });

    $("#registracija").submit( function(event) {
        if(!required() || validacija()){
            event.preventDefault();
        }
        var forma = $("#registracija");

        $.ajax({
            type: "POST",
            url: "registracija_obrada.php",
            data: forma.serialize(),
            
            success: function (data) {
                $("#greske").html(data['poruka']);
            }


        });
    });
});