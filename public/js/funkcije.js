var crud ={

    dorpdownKorisnik: function(){

    },
    
    dropdownLokacija: function () {
        
    },
    
    dropdownFilm: function () {
        
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
    }

};