$(document).ready(function(){
    "use strict";

    $.ajax({
        url: "src/katalozi/crud_katalog.php",
        type: "GET",
        data:{
            tablica : crud.getUrlVariable("tablica"),
            sort : 0,
            pojam : 1,
            aktivna_stranica : 0  // prva stranica je 0 zbog OFFSET: prikaz*0
        },

        success: function (data) {
            data = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
            $("#paginacija").html(nacrtaj_paginaciju(data['broj_stranica']));
            $("#search").html(nacrtaj_search(5));

        }
    });

    function nacrtaj_search(akcija){
        var tablica = crud.getUrlVariable("tablica");
        var prikaz_searcha = "<form method='get' action='src/katalozi/crud_katalog.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='tablica' value='"+tablica+"'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+akcija+"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }
    
    function nacrtaj_tablicu(data) {

        var tablica = data.tablica;

        var prikaz_lokacija = "<button id='gumb-kreiraj'>";
        prikaz_lokacija += "Dodaj novi zapis";
        prikaz_lokacija += "</button>";

        prikaz_lokacija += "<table class='tablica'>";
        prikaz_lokacija += "<tr>";
        prikaz_lokacija += "<th>Id</th>";
        prikaz_lokacija += "<th>"+ tablica +"</th>";
        prikaz_lokacija += "<th>Funkcije</th>";
        prikaz_lokacija += "</tr>";

        $.each(data.podaci, function (index, vrijednost) {

            prikaz_lokacija += "<tr>";
            prikaz_lokacija += "<td>"+ vrijednost.id +"</td>"
            prikaz_lokacija += "<td>"+ vrijednost.naziv +"</td>";

            prikaz_lokacija += "<td>";
            prikaz_lokacija += "<button class='gumb-edit' data-id='"+ vrijednost.id +"'>Uredi</button>";
            prikaz_lokacija += "<button class='gumb-delete' data-id='"+ vrijednost.id +"'>Izbriši</button>";
            prikaz_lokacija += "</td>";
            prikaz_lokacija += "</tr>";

        });

        prikaz_lokacija += "</table>";
        return prikaz_lokacija;
    }

    function nacrtaj_formu(akcija, id) {
        var tablica = crud.getUrlVariable("tablica");
        var prikaz_forme = "<form action='src/katalozi/crud_katalog.php' ";
        prikaz_forme += "id='novi_zapis' method='get' enctype='application/x-www-form-urlencoded'>";

        prikaz_forme += "<label for='naziv_"+tablica+"'>"+tablica+"</label>";
        prikaz_forme += "<input type='text' name='naziv' id='naziv'><br/>";
        prikaz_forme += "<input type='hidden' name='tablica' value='"+ tablica +"'>";
        prikaz_forme += "<input type='hidden' name='akcija' value='"+akcija+"'>";
        prikaz_forme += "<input type='hidden' name='id' value='"+id+"'>";

        prikaz_forme += "<input type='submit' value='Dodaj'>";
        prikaz_forme += "</form>";

        return prikaz_forme;
    }

    function nacrtaj_paginaciju(broj_stranica) {

        var paginacija = "";
        var broj=0;
        for (var i=0; i<broj_stranica; i++){
            broj = i+1;
            paginacija += "<span class='broj-paginacija' style='cursor: pointer' data-stranica='"+ i +"'>"+ broj +" </span>";
        }
        return paginacija;

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
                $("#forma").html("");
                $("#paginacija").html(nacrtaj_paginaciju(data['broj_stranica']));
                //poruka potvrde?
            }
        });
    });

    $(document).on('click', '.broj-paginacija', function () {

        $.ajax({
            url : 'src/katalozi/crud_katalog.php',
            type : 'GET',
            data : {
                tablica : crud.getUrlVariable("tablica"),
                stranica : $(this).attr('data-stranica')
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#forma").html("");
                $("#paginacija").html(nacrtaj_paginaciju(data['broj_stranica']));

            }

        });

    });

    //kasno kreiranje elementa pa se mora koristiti ovaj način selektiranja elemenata
    $(document).on('click', '#gumb-kreiraj', function() {

        var forma = nacrtaj_formu(2,0);
        $("#forma").html(forma);

    });

    $(document).on('click', '.gumb-edit', function() {
        var id = $(this).attr("data-id");
        $.ajax({
            url: 'src/katalozi/crud_katalog.php',
            type: 'GET',
            data: {
                tablica: crud.getUrlVariable("tablica"),
                id: id,
                akcija: 3
            },

            success: function (data) {
                var prikaz = JSON.parse(data);
                var forma = nacrtaj_formu(4, prikaz['id']);
                $("#forma").html(forma);
                $("#naziv").val(prikaz['naziv']);

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
                        url: 'src/katalozi/crud_katalog.php',
                        type: 'GET',
                        data: {
                            tablica : crud.getUrlVariable("tablica"),
                            id : id,
                            akcija : 1
                        },

                        success: function (data) {
                            data = JSON.parse(data);
                            $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                            $("#paginacija").html(nacrtaj_paginaciju(data['broj_stranica']));
                            $("#search").html(nacrtaj_search(5));
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

    //kod zaustavljanja redirecta, podaci iz forme se moraju poslati preko data varijable u ajax-u
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
                $("#forma").html("");
                $("#paginacija").html(nacrtaj_paginaciju(data['broj_stranica']));
                $("#search").html(nacrtaj_search(5));
                //poruka potvrde?
            }
        });

    });

});