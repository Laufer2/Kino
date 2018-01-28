$(document).ready( function(){
    "use strict";

    pocetna();

    function pocetna(id, akcija, mail, korisnik, broj, projekcija, vrijeme) {
        $.ajax({
            url : 'src/rezervacije/potvrde.php',
            type : 'POST',
            data : {
                aktivna_stranica : 0,
                akcija : akcija,
                selectmenu : 1,
                id: id,
                mail : mail,
                korisnik : korisnik,
                broj : broj,
                projekcija : projekcija,
                vrijeme : vrijeme
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#lokacije-potvrde").html(padajuci_izbornik(data.lokacija))
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#search").html(search(5, data.lok));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
                if("poruka" in data){
                    $("#poruke").html(data.poruka);
                }
            }
        });
    }

    function padajuci_izbornik(data){

        var padajuci = "<select id='lokacija'>";

        $.each(data, function (index, value) {
            padajuci += "<option value='"+ value.id +"'>"+ value.naziv +"</option>";
        });

        padajuci += "</select>";

        return padajuci;
    }

    function search(akcija, lokacija){
        var prikaz_searcha = "<form method='post' action='src/rezervacije/potvrde.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='hidden' name='lokacija' value='"+ lokacija +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Projekcija";
        prikaz_tablice += "<button class='silazno' data-stupac='f.naziv_film'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='f.naziv_film'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Vrijeme";
        prikaz_tablice += "<button class='silazno' data-stupac='p.dostupan_do'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='p.dostupan_do'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Korisnik";
        prikaz_tablice += "<button class='silazno' data-stupac='k.korisnicko_ime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.korisnicko_ime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Broj rezervacija</th>";
        prikaz_tablice += "<th>Max rezervacija</th>";
        prikaz_tablice += "<th>Dostupna mjesta</th>";
        prikaz_tablice += "<th>Akcije</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, rezervacija) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ rezervacija.projekcija +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.vrijeme +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.korisnik +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.broj_rezervacija +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.max +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.ostalo +"</td>";
            prikaz_tablice += "<td></td>";
            prikaz_tablice += "<td>";

            if(parseInt(rezervacija.ostalo) < parseInt(rezervacija.broj_rezervacija)){
                prikaz_tablice += "<button class='gumb-potvrdi' data-id='"+ rezervacija.id +"' disabled>Potvrdi</button>";
            }else{
                prikaz_tablice += "<button class='gumb-potvrdi' data-id='"+ rezervacija.id +"' data-mail='"+ rezervacija.mail +"'";
                prikaz_tablice += " data-projekcija='"+rezervacija.projekcija+"' data-korisnik='"+ rezervacija.korisnik +"'" +
                    " data-broj='"+ rezervacija.broj_rezervacija +"' data-vrijeme='"+ rezervacija.vrijeme +"'>Potvrdi</button>";
            }

            prikaz_tablice += "<button class='gumb-odbij' data-id='"+ rezervacija.id +"' data-mail='"+ rezervacija.mail +"' ";
            prikaz_tablice += " data-projekcija='"+rezervacija.projekcija+"' data-korisnik='"+ rezervacija.korisnik +"'" +
                " data-broj='"+ rezervacija.broj_rezervacija +"' data-vrijeme='"+ rezervacija.vrijeme +"'>Odbij</button>";

            prikaz_tablice += "</td>";

            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function sort(tip_sorta, stupac){
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        var lokacija = $("#lokacija").val();

        $.ajax({
            url: 'src/rezervacije/potvrde.php',
            type: 'POST',
            data : {
                stupac : stupac,
                tip_sorta : tip_sorta,
                pojam : pojam,
                akcija : akcija,
                lokacija : lokacija
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta, data.stupac));
            }
        });
    }

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";
        var lokacija = $("#lokacija").val();
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "src/rezervacije/potvrde.php",
            type: "POST",
            data: {
                aktivna_stranica: $(this).attr("data-stranica"),
                tip_sorta: $(this).attr("data-tip_sorta"),
                stupac: $(this).attr("data-stupac"),
                pojam: pojam,
                akcija: akcija,
                lokacija: lokacija
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                if(data.stupac.length > 0){
                    $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, data.tip_sorta, data.stupac));
                }else{
                    $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
                }
            }
        });
    });

    $(document).on('click', '.uzlazno', function () {
        sort('ASC', $(this).attr("data-stupac"));
    });

    $(document).on('click', '.silazno', function () {
        sort('DESC', $(this).attr("data-stupac"));
    });

    $(document).on('click', '.gumb-odbij', function(){
        var id = $(this).attr("data-id");
        var mail = $(this).attr("data-mail");
        var korisnik = $(this).attr("data-korisnik");
        var broj = $(this).attr("data-broj");
        var projekcija = $(this).attr("data-projekcija");
        var vrijeme = $(this).attr("data-vrijeme");


        $("#dialog-potvrda").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Odbij rezervaciju": function() {
                    //brisanje i refresh tablice

                    pocetna(id,0,mail,korisnik,broj,projekcija,vrijeme);

                    $( this ).dialog( "close" );

                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });

    $(document).on('click', '.gumb-potvrdi', function() {
        var id = $(this).attr("data-id");
        var mail = $(this).attr("data-mail");
        var korisnik = $(this).attr("data-korisnik");
        var broj = $(this).attr("data-broj");
        var projekcija = $(this).attr("data-projekcija");
        var vrijeme = $(this).attr("data-vrijeme");

        $("#poruke").html("Slanje e-mail poruke korisniku...");

        pocetna(id, 1, mail, korisnik, broj, projekcija, vrijeme);
    });

    $(document).on('change','#lokacija', function () {
        var id = $("#lokacija").val();
        $.ajax({
            url : "src/rezervacije/potvrde.php",
            type : "POST",
            data : {
                lokacija : id
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#poruke").html();
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#search").html(search(5, id));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
            }
        });
    });

    $(document).on('submit', '#pretraga', function (event){

        var forma = $("#pretraga");
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data : forma.serialize(),

            success: function (data) {
                data = JSON.parse(data);
                $("#poruke").html();
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));

                if("poruka" in data) {
                    $("#poruke").html(data.poruka);
                }

            }
        });
    });

});