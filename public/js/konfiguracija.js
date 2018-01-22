$(document).ready( function () {
    "use strict";

    $.ajax({

        url : "src/klase/konfiguracija.php",
        type: "POST",
        data : {
            akcija : 0
        },

        success: function(data){
            data = JSON.parse(data);
            $.each(data, function (key, val) {
                $("#" + key ).val(val);
            });
        }
    });

    $(document).on('click', '#dohvati-pomak', function(){

        $.ajax({

            url : "src/klase/konfiguracija.php",
            type: "POST",
            data: {
                akcija : 1
            },

            success: function (data) {
                data = JSON.parse(data);
                if("parametar" in data){
                    $("#pomak").val(data.parametar);
                }
                $("#poruke").html(data.poruka);
            }

        });
    });

    $(document).on('submit', '#postavi_pomak', function (event) {

        event.preventDefault();
        postavi($(this), $("#pomak").val(), "pomak");

    });

    $(document).on('submit', '#postavi_sesiju', function (event) {

        event.preventDefault();
        postavi($(this), $("#sesija").val(), "trajanje_sesije");

    });

    $(document).on('submit', '#postavi_prikaze', function (event) {

        event.preventDefault();
        postavi($(this), $("#prikazi").val(), "prikazi_po_stranici");

    });

    $(document).on('submit', '#postavi_rok', function (event) {

        event.preventDefault();
        postavi($(this), $("#rok").val(), "rok_trajanja_aktivacijskog_linka");

    });

    $(document).on('submit', '#postavi_prijave', function (event) {

        event.preventDefault();
        postavi($(this), $("#prijave").val(), "neuspjesne_prijave");

    });
    
    function postavi(forma, parametar, postavi) {
        var a = 2;
        $.ajax({

            url : "src/klase/konfiguracija.php",
            type: "POST",
            data: {
                akcija : 2,
                parametar : parametar,
                postavi : postavi
            },

            success: function (data) {
                data = JSON.parse(data);
                if("parametar" in data){
                    $('[name='+ postavi +']', forma).val(data.parametar);
                }
                $("#poruke").html(data.poruka);
            }
        });
    }
});