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
            if(data.poruka){
                $("#poruke").append(data.poruka).css("display", "block");
                $("#rezerviraj").prop('disabled', true);
            }

        }

    });

    function film(data){

        $.each(data.projekcija, function (index, value) {

            $("#naziv_filma").append(value.naziv);

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

            $("#trajanje").append(value.trajanje + " min");

            $("#sadrzaj").append(value.sadrzaj);

            $("#lokacija").append(value.lokacija);

            $("#pocetak").append(value.pocetak);

            $("#dostupan_od").append(value.dostupan_od);

            $("#ukupno_mjesta").append(value.max_gledatelja);

            $("#dostupno_mjesta").append(value.ostalo);
            if(value.ostalo === 0){
                $("#poruke").append("Nema dostupnih mjesta za rezervaciju.").css("display", "block");
                $("#rezerviraj").prop('disabled', true);
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
                $("#poruke").append(data.poruka).css("display","block").css("background-color", "#4CAF50");
            }
            });
        }
    });
});