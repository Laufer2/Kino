$(document).ready( function () {
    "use strict";

    zanrovi();

    function zanrovi() {
        $.ajax({
            url: "src/filmovi/filmovi.php",
            type: "POST",
            data: {
                selectmenu: 1
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#zanr-filmovi").append(padajuci_izbornik(data.zanr));
            }
        });
    }

    function padajuci_izbornik(data){
        var padajuci = "<select name='zanr[]'>";
        padajuci += "<option selected>Odaberite...</option>";

        $.each(data, function (index, value) {
            padajuci += "<option value='"+ value.id +"'>"+ value.naziv +"</option>";
        });

        padajuci += "</select>";
        padajuci += "<button type='button' id='novi-zanr'>+</button><br/>";

        return padajuci;
    }

    $(document).on('click', '#novi-zanr', function () {
        zanrovi();
    });

    $(document).on('click', '#novi-redatelj', function () {
        var redatelj = "<input type='text' name='redatelj[]'><br/>";
        $("#redatelji").append(redatelj);
    });

    $(document).on('click', '#novi-glumac', function () {
        var glumac = "<input type='text' name='glumac[]'><br/>";
        $("#glumci").append(glumac);
    });

    $(document).on('click', '#novi-scenarist', function () {
        var scenarist = "<input type='type' name='scenarist[]'><br/>";
        $("#scenaristi").append(scenarist);
    });

    $(document).on('submit', '#novi-film', function (event) {

        event.preventDefault();

        $.ajax({
            url : "src/filmovi/filmovi.php",
            type : "POST",
            data : $(this).serialize(),

            success: function (data) {
                data = JSON.parse(data);
                $("#poruke").html(data.poruka);
            }
        });

    });

});