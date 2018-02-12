$(document).ready(function(){
    "use strict";

    $.ajax({
        url: "src/slike/pregled_slika.php",
        type: "POST",
        data : {
            sve : 1
        },

        success: function (data) {
            data = JSON.parse(data);
            $(".lista-slika").html(prikazi_slike(data));

            if(data.poruka){
                $("#test").html(data.poruka).css("display","block");
            }else{
                $("#test").html("").css("display","none");
            }

        }
    });


    function prikazi_slike(data) {

        var galerija = "";

        $.each(data.podaci, function (index, value) {

            galerija += "<a href='"+ value.href +"' target='_blank'>";
            galerija += "<img class='slikice' src='"+ value.href +"'>";
            galerija += "</a>";

        });

        return galerija;
    }

    $(document).on('submit', '#pretraga', function (event){

        var forma = $("#pretraga");
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data : forma.serialize(),

            success: function (data) {
                data = JSON.parse(data);
                $(".lista-slika").html(prikazi_slike(data));

                if(data.poruka){
                    $("#test").html(data.poruka).css("display","block");
                }else{
                    $("#test").html("").css("display","none");
                }

            }
        });
    });

});