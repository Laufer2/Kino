$(document).ready( function(){
    "use strict";

    $.ajax({
        url : 'src/crud/rezervacija.php',
        type : 'POST',
        data : {
            aktivna_stranica : 0,
            akcija : 10
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#search").html(search(5));
            $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));
        }
    });

    function search(akcija){
        var prikaz_searcha = "<form method='post' action='src/crud/rezervacija.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<a href='#forma'><button id='gumb-kreiraj'>";
        prikaz_tablice += "Dodaj novi zapis";
        prikaz_tablice += "</button></a>";

        prikaz_tablice += "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Korisnik";
        prikaz_tablice += "<button class='silazno' data-stupac='k.korisnicko_ime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.korisnicko_ime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Status";
        prikaz_tablice += "<button class='silazno' data-stupac='r.status'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='r.status'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Br rez</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Film";
        prikaz_tablice += "<button class='silazno' data-stupac='f.naziv_film'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='f.naziv_film'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Vrijeme";
        prikaz_tablice += "<button class='silazno' data-stupac='p.dostupan_do'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='p.dostupan_do'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Lokacija";
        prikaz_tablice += "<button class='silazno' data-stupac='l.naziv_lokacija'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='l.naziv_lokacija'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Funkcije</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, rezervacija) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ rezervacija.korisnik +"</td>"
            prikaz_tablice += "<td>"+ rezervacija.status +"</td>"
            prikaz_tablice += "<td>"+ rezervacija.broj_rezervacija +"</td>";
            prikaz_tablice += "<td>"+ rezervacija.film+"</td>";
            prikaz_tablice += "<td>"+ rezervacija.vrijeme+"</td>";
            prikaz_tablice += "<td>"+ rezervacija.lokacija+"</td>";

            prikaz_tablice += "<td>";
            prikaz_tablice += "<a href='#forma'><button class='gumb-edit' data-id='"+ rezervacija.id +"' data-projek='"+ rezervacija.id_projekcija +"'>Uredi</button></a>";
            prikaz_tablice += "<button class='gumb-delete' data-id='"+ rezervacija.id +"'>Izbriši</button>";
            prikaz_tablice += "</td>";
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_formu(lista, akcija) {

        var prikaz_forme = "<form action='src/crud/rezervacija.php' ";
        prikaz_forme += "id='novi_zapis' method='post' enctype='multipart/form-data'>";

        prikaz_forme += "<label for='korisnik'>Korisnik</label><br>";
        // select za lokaciju

        prikaz_forme += "<select name='korisnik' id='korisnik'>";
        $.each(lista.korisnik, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='status'>Status rezervacije</label><br>";
        prikaz_forme += "<input type='number' name='status' id='status 'required><br/>";

        prikaz_forme += "<label for='broj_rezervacija'>Broj rezervacija</label><br>";
        prikaz_forme += "<input type='number' name='broj_rezervacija' id='broj_rezervacija' required><br/>";

        prikaz_forme += "<label for='projekcija'>Projekcija</label><br>";

        prikaz_forme += "<select name='projekcija' id='projekcija'>";
        $.each(lista.projekcija, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });

        prikaz_forme += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_forme += "<input type='hidden' name='id'>";

        prikaz_forme += "<input type='submit' value='Dodaj'>";
        prikaz_forme += "</form>";

        return prikaz_forme;
    }

    function sort(tip_sorta, stupac){
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }

        $.ajax({
            url: 'src/crud/rezervacija.php',
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
            url: "src/crud/rezervacija.php",
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

    $(document).on('click', '.gumb-delete', function(){
        var id = $(this).attr("data-id");
        $("#dialog-potvrda").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Izbriši zapis": function() {
                    //brisanje i refresh tablice

                    $.ajax({
                        url: 'src/crud/rezervacija.php',
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

    $(document).on('click', '.gumb-edit', function() {
        var id = $(this).attr("data-id");
        var projek = $(this).attr("data-projek");

        $.ajax({
            url: 'src/crud/rezervacija.php',
            type: 'POST',
            data: {
                id: id,
                akcija: 4,
                selectmenu : 1,
                id_projekcija : projek
            },

            success: function (data) {
                var lista = JSON.parse(data);
                $("#forma").html( nacrtaj_formu(lista, 2));

                var forma = $("#novi_zapis");

                $.each(lista.podaci, function(index, value){
                    $.each(value,function (ind, val) {
                        $('[name='+ind+']', forma).val(val);
                    });
                });

            },
            error: function (xhr) {
                $("#test").html(xhr.status);
            }
        });

    });

    $(document).on('click', '#gumb-kreiraj', function() {

        $.ajax({
            url : 'src/crud/rezervacija.php',
            type : 'POST',
            data : {
                selectmenu : 1
            },

            success: function (data) {
                var lista = JSON.parse(data);
                $("#forma").html( nacrtaj_formu(lista, 1));
            }
        });
    });

    $(document).on('submit', '#novi_zapis', function(event) {

        var forma = $("#novi_zapis");
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data : forma.serialize(),

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));

                if(data.poruka['poruka']){
                    $("#test").html("Dogodila se greška.").css("display","block");

                }else{
                    $("#test").css("display","none");
                    $("#forma").html("");
                }

                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));
                $("#search").html(search(5));
            }
        });

    });

});