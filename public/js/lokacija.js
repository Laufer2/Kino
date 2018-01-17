$(document).ready(function () {
    "use strict";

    function iscrtavanje( broj_stranica, kliknuta_stranica){

        if(kliknuta_stranica === 0){//prva stranica


        }

        if(kliknuta_stranica+2 === broj_stranica){

        }

    }



    $.ajax({
        url: "prikaz_lokacija.php",
        type: "POST",
        data:{
            sortiranje: 0,
            broj_stranice: 0,
            stupac: 0
        },

        success: function (data) {

            //nacrtaj tablicu
        }


    });



});