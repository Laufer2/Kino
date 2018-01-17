$(document).ready(function(){
    "use strict";
    
    function nacrtaj_tablicu(data) {

        var tablica = data.tablica;
        var prikaz_lokacija = "<table class='tablica'>";
        prikaz_lokacija += "<tr>";
        prikaz_lokacija += "<th>ID</th>";
        prikaz_lokacija += "<th>"+ tablica +"</th>";
        prikaz_lokacija += "<th>Funkcije</th>";
        prikaz_lokacija += "</tr>";

        $.each(data.podaci, function (index, vrijednost) {

            prikaz_lokacija += "<tr>";
            prikaz_lokacija += "<td>"+ vrijednost.id +"</td>";
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

    function nacrtaj_formu() {
        var tablica = crud.getUrlVariable("tablica");
        var prikaz_forme = "<form action='src/katalozi/crud_katalog.php' method='post'enctype='application/x-www-form-urlencoded'>";

        prikaz_forme += "<label for='naziv_"+tablica+"'>"+tablica+"</label>";
        prikaz_forme += "<input type='text' name='naziv_"+tablica+"' id='naziv_'"+tablica+"'> <br/>";
        prikaz_forme += "</form>";

    }
    
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
            var prikaz = JSON.parse(data);
            $("#prikaz-tablice").html(nacrtaj_tablicu(prikaz));
        }
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
                            var prikaz = JSON.parse(data);
                            $("#prikaz-tablice").html(nacrtaj_tablicu(prikaz));
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

});