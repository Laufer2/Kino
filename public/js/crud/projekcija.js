$(document).ready( function(){
    "use strict";

    $.ajax({
        url : 'src/crud/projekcija.php',
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
        var prikaz_searcha = "<form method='post' action='src/crud/projekcija.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
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
        prikaz_tablice += "Lokacija";
        prikaz_tablice += "<button class='silazno' data-stupac='l.naziv_lokacija'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='l.naziv_lokacija'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Film";
        prikaz_tablice += "<button class='silazno' data-stupac='f.naziv_film'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='f.naziv_film'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Max gledatelja</th>";
        prikaz_tablice += "<th>Dostupan od</th>";
        prikaz_tablice += "<th>Dostupan do</th>";


        prikaz_tablice += "<th>Funkcije</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, projekcija) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ projekcija.lokacija +"</td>";
            prikaz_tablice += "<td>"+ projekcija.film +"</td>";
            prikaz_tablice += "<td>"+ projekcija.max_gledatelja +"</td>";
            prikaz_tablice += "<td>"+ projekcija.dostupan_od +"</td>";
            prikaz_tablice += "<td>"+ projekcija.dostupan_do +"</td>";


            prikaz_tablice += "<td>";
            prikaz_tablice += "<a href='#forma'><button class='gumb-edit' data-id='"+ projekcija.id +"'>Uredi</button></a>";
            prikaz_tablice += "<button class='gumb-delete' data-id='"+ projekcija.id +"'>Izbriši</button>";
            prikaz_tablice += "</td>";
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_formu(lista, akcija) {

        var prikaz_forme = "<form action='src/crud/projekcija.php' ";
        prikaz_forme += "id='novi_zapis' method='post' enctype='application/x-www-form-urlencoded'>";


        prikaz_forme += "<label for='lokacija'>Lokacija</label><br>";
        prikaz_forme += "<select name='lokacija' id='lokacija'>";
        $.each(lista.lokacija, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });

        prikaz_forme += "</select><br/>";
        prikaz_forme += "<label for='film'>Film</label><br>";
        // select za lokaciju

        prikaz_forme += "<select name='film' id='film'>";
        $.each(lista.film, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='max_gledatelja'>Max gledatelja</label><br>";
        prikaz_forme += "<input type='number' name='max_gledatelja' id='max_gledatelja 'required><br/>";

        //dostupan od
        prikaz_forme += "<fieldset>";
        prikaz_forme += "<legend>Dostupan za rezervacije od</legend>";
        prikaz_forme += "<label for='datum1'>Datum</label><br>";
        prikaz_forme += "<input type='date' name='datum1' required><br>";
        prikaz_forme += "<label for='sati1'>Vrijeme</label><br>";
        prikaz_forme += "<input type='number' name='sati1' placeholder='sati' min='0' max='23' required>";
        prikaz_forme += "<input type='number' name='minute1' placeholder='min' min='0' max='60' required><br/>";
        prikaz_forme += "</fieldset>";

        prikaz_forme += "<fieldset>";
        prikaz_forme += "<legend>Dostupan za rezervacije do</legend>";
        prikaz_forme += "<label for='datum2'>Datum</label><br>";
        prikaz_forme += "<input type='date' name='datum2' required><br>";
        prikaz_forme += "<label for='sati2'>Vrijeme</label><br>";
        prikaz_forme += "<input type='number' name='sati2' placeholder='sati' min='0' max='23' required><br>";
        prikaz_forme += "<input type='number' name='minute2' placeholder='min' min='0' max='60' required><br/>";
        prikaz_forme += "</fieldset>";

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
            url: 'src/crud/projekcija.php',
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
            url: "src/crud/projekcija.php",
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
                        url: 'src/crud/projekcija.php',
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
        var tablice = ["lokacija", "film"];

        $.ajax({
            url: 'src/crud/projekcija.php',
            type: 'POST',
            data: {
                id: id,
                akcija: 4,
                selectmenu : 1,
                tablica : tablice
            },

            success: function (data) {
                var lista = JSON.parse(data);
                $("#forma").html( nacrtaj_formu(lista, 2));

                var forma = $("#novi_zapis");
                $("#ulica").val(lista['podaci'].ulica);
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
        var tablice = ["lokacija","film"];

        $.ajax({
            url : 'src/crud/projekcija.php',
            type : 'POST',
            data : {
                tablica : tablice,
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
                    $("#test").html("Adresa za tu lokaciju već postoji.");

                }else{
                    $("#test").html("");
                    $("#forma").html("");
                }

                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));
                $("#search").html(search(5));
            }
        });

    });

});