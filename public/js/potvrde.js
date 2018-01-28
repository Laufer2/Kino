$(document).ready( function(){
    "use strict";

    $.ajax({
        url : 'src/rezervacije/potvrde.php',
        type : 'POST',
        data : {
            aktivna_stranica : 0,
            akcija : 10,
            selectmenu : 1
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#lokacije-potvrde").html(padajuci_izbornik(data.lokacije))
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#search").html(search(5));
            $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
        }
    });

    function padajuci_izbornik(data){

        var padajuci = "<select id='lokacije'>";

        $.each(data, function (index, value) {
            padajuci += "<option value='"+ value.id +"'>"+ value.naziv +"</option>";
        });

        padajuci += "</select>";

        return padajuci;
    }

    function search(akcija){
        var prikaz_searcha = "<form method='post' action='src/rezervacije/potvrde.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Projekcija";
        prikaz_tablice += "<button class='silazno' data-stupac='l.naziv_lokacija'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='l.naziv_lokacija'>&#708;</button>"; //ASC
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
            prikaz_tablice += "<td>"+ rezervacija.korisnik +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.broj_rezervacija +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.max +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.ostalo +"</td>";
            prikaz_tablice += "<td></td>";
            prikaz_tablice += "<td>";

            if(parseInt(rezervacija.ostalo) < parseInt(rezervacija.broj_rezervacija)){
                prikaz_tablice += "<button class='gumb-potvrdi' data-id='"+ rezervacija.id +"' disabled>Potvrdi</button>";
            }else{
                prikaz_tablice += "<button class='gumb-potvrdi' data-id='"+ rezervacija.id +"'>Potvrdi</button>";
            }

            prikaz_tablice += "<button class='gumb-odbij' data-id='"+ rezervacija.id +"'>Odbij</button>";
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

        $.ajax({
            url: 'src/rezervacije/potvrde.php',
            type: 'POST',
            data : {
                stupac : stupac,
                tip_sorta : tip_sorta,
                pojam : pojam,
                akcija : akcija
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
                akcija: akcija
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
        $("#dialog-potvrda").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Odbij rezervaciju": function() {
                    //brisanje i refresh tablice

                    $.ajax({
                        url: 'src/rezervacije/potvrda.php',
                        type: 'POST',
                        data: {
                            id : id,
                            akcija : 3
                        },

                        success: function (data) {
                            data = JSON.parse(data);
                            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                            $("#search").html(search(5));
                            $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "",""));

                        }
                    });

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

    });

    $(document).on('change','#lokacije', function () {
        var id = $("#lokacije").val();
        $.ajax({
            url : "src/rezervacije/potvrde.php",
            type : "POST",
            data : {
                lokacije : id
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#search").html(search(5));
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
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));

                if(data.poruka['poruka']){
                    $("#test").html("Nema podataka.");

                }
                $("#forma").html("");
            }
        });
    });

});