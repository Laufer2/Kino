var funkcija ={

    validacija: function (polje_validacija) {
        "use strict";
        $("#greske3").html("");
        for ( var i = 0; i < polje_validacija.length; i++){
            if(polje_validacija[i] === 0){
                return false;
            }
        }
        return true;
    },

    //preuzeto s https://css-tricks.com/snippets/javascript/get-url-variables/
    getUrlVariable: function (variable) {
        "use strict";
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0; i<vars.length; i++) {
            var pair = vars[i].split("=");
            if(pair[0] === variable){
                return pair[1];
            }
        }
        return(false);
    },

    paginacija : function(aktivna_stranica, broj_stranica, tip_sorta, stupac) {
        "use strict";

        var paginacija = "";
        if(broj_stranica > 1) {

            var broj, pocetak = 0;

            paginacija = "<span class='jump-to-first broj-paginacija' style='cursor: pointer' " +
                "data-stranica='0' data-tip_sorta='" + tip_sorta + "' data-stupac='" + stupac + "'> |< &nbsp;</span>";

            if (aktivna_stranica > 2) {
                paginacija += "<span class='prednje'>&nbsp; ... &nbsp;</span>"; // na početku
            } else {
                $(".prednje").css("display: none;");
            }

            var max = aktivna_stranica + 3;
            if (max > broj_stranica) {
                max = broj_stranica;
            }

            if (aktivna_stranica < 3) {
                pocetak = 0;
            } else {
                pocetak = aktivna_stranica - 2;
            }

            for (var i = pocetak; i < max; i++) {
                broj = i + 1;
                if (i === aktivna_stranica) {
                    paginacija += "<span class='broj-paginacija' style='cursor: pointer; color: red' " +
                        "data-stranica='" + i + "' data-stupac='" + stupac + "' data-tip_sorta='" + tip_sorta + "'>" + broj + " </span>";
                    continue;
                }
                paginacija += "<span class='broj-paginacija' style='cursor: pointer' " +
                    "data-stranica='" + i + "' data-stupac='" + stupac + "' data-tip_sorta='" + tip_sorta + "'>" + broj + " </span>";
            }

            if ((aktivna_stranica + 3) < broj_stranica) {
                paginacija += "<span class='zadnje'>&nbsp; ... &nbsp;</span>"; // na kraju
            } else {
                $(".zadnje").css("display: none;");
            }

            var zadnja = broj_stranica - 1;
            paginacija += "<span class='jump-to-first broj-paginacija' style='cursor: pointer' " +
                "data-stranica='" + zadnja + "' data-stupac='" + stupac + "' data-tip_sorta='" + tip_sorta + "'>&nbsp;>| </span>";

        }
        return paginacija;
    }
};