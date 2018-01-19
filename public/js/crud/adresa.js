$(document).ready( function(){
    "use strict";

    $.ajax({
        url : 'src/crud/adresa.php',
        type : 'POST',
        data : {
            stranica : 0,
            akcija : 10
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#search").html(nacrtaj_search(5));
            //$("#paginacija").html(nacrtaj_paginaciju(data['broj_stranica']));

        }

    });

    function nacrtaj_search(akcija){
        var prikaz_searcha = "<form method='post' action='src/crud/adresa.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }


    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<button id='gumb-kreiraja'>";
        prikaz_tablice += "Dodaj novi zapis";
        prikaz_tablice += "</button>";

        prikaz_tablice += "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>Lokacija</th>";
        prikaz_tablice += "<th>Ulica</th>";
        prikaz_tablice += "<th>Broj</th>";
        prikaz_tablice += "<th>Poštanski broj</th>";
        prikaz_tablice += "<th>Grad</th>";
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
            prikaz_tablice += "<button class='gumb-edit' data-id='"+ adresa.id +"'>Uredi</button>";
            prikaz_tablice += "<button class='gumb-delete' data-id='"+ adresa.id +"'>Izbriši</button>";
            prikaz_tablice += "</td>";
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_forma(lista, akcija, id) {

        var prikaz_forme = "<form action='src/crud/adresa.php' ";
        prikaz_forme += "id='novi_zapis' method='post' enctype='application/x-www-form-urlencoded'>";

        prikaz_forme += "<label for='lokacija'>Lokacija</label>";
        // select za lokaciju

        prikaz_forme += "<select name='lokacija' id='lokacija'>";
        $.each(lista.lokacija, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='ulica'>Ulica</label>";
        prikaz_forme += "<input type='text' name='ulica' id='ulica 'required><br/>";

        prikaz_forme += "<label for='broj'>Broj</label>";
        prikaz_forme += "<input type='number' name='broj' id='broj' required><br/>";

        prikaz_forme += "<label for='postanski_broj'>Poštanski broj</label>";
        prikaz_forme += "<input type='number' name='postanski_broj' id='postanski_broj' required><br/>";

        prikaz_forme += "<label for='grad'>Grad</label>";

        prikaz_forme += "<select name='grad' id='grad'>";
        $.each(lista.grad, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='drzava'>Država</label>";

        prikaz_forme += "<select name='drzava' id='drzava'>";
        $.each(lista.drzava, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_forme += "<input type='hidden' name='id' value='"+ id +"'>";

        prikaz_forme += "<input type='submit' value='Dodaj'>";
        prikaz_forme += "</form>";

        return prikaz_forme;
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
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
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
                        url: 'src/crud/adresa.php',
                        type: 'POST',
                        data: {
                            id : id,
                            akcija : 3
                        },

                        success: function (data) {
                            data = JSON.parse(data);
                            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                            $("#search").html(nacrtaj_search(5));
                            //$("#paginacija").html(nacrtaj_paginaciju(data['broj_stranica']));

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
                $("#forma").html( nacrtaj_forma(lista, 2, 2));

                $("#test").html("test");

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

    $(document).on('click', '#gumb-kreiraja', function() {
        var tablice = ["lokacija","grad","drzava"];

        $.ajax({
            url : 'src/crud/adresa.php',
            type : 'POST',
            data : {
                tablica : tablice,
                selectmenu : 1
            },

            success: function (data) {
                var lista = JSON.parse(data);
                $("#forma").html( nacrtaj_forma(lista, 1 ,0));
            }
        });

        //selectmenu_podaci(tablice, 1);

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

                //$("#paginacija").html(nacrtaj_paginaciju(data['broj_stranica']));
                $("#search").html(nacrtaj_search(5));
                //poruka potvrde?
            }
        });

    });

});