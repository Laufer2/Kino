$(document).ready(function () {
    "use strict";

    $.ajax({

        url : "src/naslovnica/projekcija.php",
        type: "POST",
        data : {
            id : funkcija.getUrlVariable('id')
        },

        success : function (data) {
            data = JSON.parse(data);
            film(data);
            dostupna_mjesta();
            if("poruka" in data){
                $("#poruke").html(data.poruka);
            }
        }

    });

    function film(data){

        $.each(data.projekcija, function (index, value) {

            $("#naziv_filma").html(value.naziv);

            $.each(value.zanr, function(ind, val){
                $("#zanrovi").append("<span>"+val+"&nbsp;</span>");
            });

            $.each(value.redatelj, function(ind, val){
                $("#redatelj").append("<span>"+val+"&nbsp;</span>");
            });

            $.each(value.glumci, function(ind, val){
                $("#glumci").append("<span>"+val+"&nbsp;</span>");
            });

            $.each(value.scenarist, function(ind, val){
                $("#zanrovi").append("<span>"+val+"&nbsp;</span>");
            });

            $("#trajanje").html(value.trajanje + " min");

            $("#sadrzaj").html(value.sadrzaj);

            $("#lokacija").html(value.lokacija);

            $("#pocetak").html(value.pocetak);

            $("#dostupan_od").html(value.dostupan_od);

            $("#ukupno_mjesta").html(value.max_gledatelja);

        });
    }

    function dostupna_mjesta(){
        $.ajax({

            url : "src/rezervacije/dostupna_mjesta.php",
            type: "POST",
            data : {
                id : funkcija.getUrlVariable('id')
            },

            success : function (data) {
                data = JSON.parse(data);
                $("#dostupno_mjesta").html(data.mjesta);
                if("poruka" in data){
                    $("#poruke").html(data.poruka);
                }
            }

        });
    }

    $(document).on('submit', '#rezerviranje', function (event) {

        event.preventDefault();

        if($("#broj_rezervacija").val() > 0){
            $.ajax({
                url : "src/rezervacije/rezerviranje.php",
                type : "POST",
                data : {
                    broj_rezervacija : $("#broj_rezervacija").val(),
                    projekcija : funkcija.getUrlVariable("id")
                },

            success: function (data) {
                data = JSON.parse(data);
                $("#poruke").html(data.poruka);
            }
            });
        }

    });

});