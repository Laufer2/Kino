$(document).ready( function(){
    "use strict";

    $.ajax({
        url : 'src/crud/adresa.php',
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
        var prikaz_searcha = "<form method='post' action='src/crud/adresa.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
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
        prikaz_tablice += "<th>Ulica</th>";
        prikaz_tablice += "<th>Broj</th>";
        prikaz_tablice += "<th>Poštanski broj</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Grad";
        prikaz_tablice += "<button class='silazno' data-stupac='g.naziv_grad'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='g.naziv_grad'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Država</th>";
        prikaz_tablice += "<th>Funkcije</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, adresa) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ adresa.lokacija +"</td>"
            prikaz_tablice += "<td>"+ adresa.ulica +"</td>"
            prikaz_tablice += "<td>"+ adresa.broj +"</td>";
            prikaz_tablice += "<td>"+ adresa.postanski_broj +"</td>";
            prikaz_tablice += "<td>"+ adresa.grad +"</td>";
            prikaz_tablice += "<td>"+ adresa.drzava +"</td>";

            prikaz_tablice += "<td>";
            prikaz_tablice += "<a href='#forma'><button class='gumb-edit' data-id='"+ adresa.id +"'>Uredi</button></a>";
            prikaz_tablice += "<button class='gumb-delete' data-id='"+ adresa.id +"'>Izbriši</button>";
            prikaz_tablice += "</td>";
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_formu(lista, akcija) {

        var prikaz_forme = "<form action='src/crud/adresa.php' ";
        prikaz_forme += "id='novi_zapis' method='post' enctype='application/x-www-form-urlencoded'>";

        prikaz_forme += "<label for='lokacija'>Lokacija</label><br>";
        // select za lokaciju

        prikaz_forme += "<select name='lokacija' id='lokacija'>";
        $.each(lista.lokacija, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='ulica'>Ulica</label><br>";
        prikaz_forme += "<input type='text' name='ulica' id='ulica 'required><br/>";

        prikaz_forme += "<label for='broj'>Broj</label><br>";
        prikaz_forme += "<input type='number' name='broj' id='broj' required><br/>";

        prikaz_forme += "<label for='postanski_broj'>Poštanski broj</label><br>";
        prikaz_forme += "<input type='number' name='postanski_broj' id='postanski_broj' required><br/>";

        prikaz_forme += "<label for='grad'>Grad</label><br>";

        prikaz_forme += "<select name='grad' id='grad'>";
        $.each(lista.grad, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='drzava'>Država</label><br>";

        prikaz_forme += "<select name='drzava' id='drzava'>";
        $.each(lista.drzava, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

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
            url: 'src/crud/adresa.php',
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
            url: "src/crud/adresa.php",
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
        $("#test").css("display","none");

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
                    $("#test").html("Nema podataka.").css("display","block");

                }
                $("#forma").html("");
            }
        });
    });

    $(document).on('click', '.gumb-delete', function(){
        $("#test").css("display","block");
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
                        url: 'src/crud/adresa.php',
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
        $("#test").css("display","none");
        var id = $(this).attr("data-id");
        var tablice = ["lokacija","grad","drzava"];

        $.ajax({
            url: 'src/crud/adresa.php',
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
                $("#lokacija").prop('disabled', true);

                $.each(lista.podaci, function(index, value){
                    $.each(value,function (ind, val) {
                        $('[name='+ind+']', forma).val(val);
                    });
                });
            },
        });

    });

    $(document).on('click', '#gumb-kreiraj', function() {
        var tablice = ["lokacija","grad","drzava"];
        $("#test").css("display","none");

        $.ajax({
            url : 'src/crud/adresa.php',
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
        $("#lokacija").prop('disabled', false);

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
                    $("#test").html("Adresa za tu lokaciju već postoji.").css("display","block");

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