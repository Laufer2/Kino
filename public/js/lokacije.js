$(document).ready( function(){
    "use strict";

    $.ajax({
        url : 'src/lokacije/lokacije.php',
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
        var prikaz_searcha = "<form method='post' action='src/lokacije/lokacije.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
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
        prikaz_tablice += "Lokacija";
        prikaz_tablice += "<button class='silazno' data-stupac='l.naziv_lokacija'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='l.naziv_lokacija'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Grad";
        prikaz_tablice += "<button class='silazno' data-stupac='g.naziv_grad'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='g.naziv_grad'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Ulica</th>";
        prikaz_tablice += "<th>Država</th>";
        prikaz_tablice += "<th>Sviđanja</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, lokacija) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ lokacija.lokacija +"</td>";
            prikaz_tablice += "<td>"+ lokacija.grad +"</td>";
            prikaz_tablice += "<td>"+ lokacija.ulica +"</td>";
            prikaz_tablice += "<td>"+ lokacija.drzava +"</td>";
            prikaz_tablice += "<td>";
            prikaz_tablice += "<button class='gumb-svidja' data-id='"+ lokacija.id +"'" +
                                ">Sviđa mi se&nbsp;(<span id='broj-svidja'>"+lokacija.lajkovi+"</span>)</button>";

            prikaz_tablice += "<button class='gumb-ne-svidja' data-id='"+ lokacija.id +"'" +
                                ">Ne sviđa mi se&nbsp;(<span id='broj-ne-svidja'>"+lokacija.ne_lajkovi+"</span>)</button>";

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
            url: 'src/lokacije/lokacije.php',
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

    function lajkovi(id, svidja) {
        //update broj-svidja
        $.ajax({
            url : 'src/lokacije/lajkovi.php',
            type: "POST",
            data : {
                lokacija : id,
                svidja : svidja
            },

            success: function (data) {
                data = JSON.parse(data);
                $("button[data-id='" + id + "'] > span[id='broj-svidja']").html(data.lajk);
                $("button[data-id='" + id + "'] > span[id='broj-ne-svidja']").html(data.nelajk);


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
            url: "src/lokacije/lokacije.php",
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

    $(document).on('click', '.gumb-svidja', function () {
        lajkovi($(this).attr('data-id'),1);

    });

    $(document).on('click', '.gumb-ne-svidja', function () {
        lajkovi($(this).attr('data-id'),0);
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
                    $("#test").html("Dogodila se greška.");

                }else{
                    $("#test").html("");
                    $("#forma").html("");
                }

                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));
                $("#search").html(search(5));
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