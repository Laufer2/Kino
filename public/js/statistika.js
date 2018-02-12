$(document).ready( function () {
    "use strict";

    pocetna();

    function pocetna() {

        $.ajax({
            url : 'src/statistike/statistika.php',
            type : 'POST',
            data : {
                aktivna_stranica : 0,
                interval : $("#interval").val(),
                tip : $("#tip").val(),
                pojam : $("#pojam").val()
            },

            success: function (data) {
                data = JSON.parse(data);
                var tip = parseInt($("#tip").val());
                var pojam = $("#pojam").val();
                $("#poruke").html("").css("display","none");

                if(typeof pojam === "undefined" || pojam === ""){

                    if(tip === 1){

                        $("#prikaz-tablice").html(nacrtaj_tablicu_stranica(data));
                        $("#search").html(search(5,$("#tip").val(), $("#interval").val()));

                    }else {

                        $("#prikaz-tablice").html(nacrtaj_tablicu_upit(data));
                        $("#search").html(search(5, $("#tip").val(), $("#interval").val()));

                    }

                } else {
                    $("#prikaz-tablice").html(nacrtaj_tablicu_korisnik(data));
                }

                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));

                if(data.poruka){
                    $("#poruke").html(data.poruka).css("display","block");
                }


                $("#legenda").html("");

                var platno1 = document.getElementById("grafovi_statistika");

                platno1.width = 400;
                platno1.height = 400;

                var grafLajkova = new graf({
                    boje : ["BlueViolet","Brown","BurlyWood","CadetBlue","Coral","CornflowerBlue",
                        "Cornsilk","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGrey","DarkGreen",
                        "DarkKhaki","DarkMagenta","DarkOliveGreen"]
                });

                grafLajkova.crtaj(data.graf, data.ukupna_posjecenost, platno1);

            }
        });
    }

    function nacrtaj_tablicu_stranica(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<thead>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Stranica";
        prikaz_tablice += "<button class='silazno' data-stupac='s.naziv_stranica'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='s.naziv_stranica'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Korisnik";
        prikaz_tablice += "<button class='silazno' data-stupac='k.korisnicko_ime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.korisnicko_ime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Vrijeme";
        prikaz_tablice += "<button class='silazno' data-stupac='vrijeme'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='vrijeme'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "</tr>";
        prikaz_tablice += "</thead>";


        $.each(data.podaci, function (index, log) {

            prikaz_tablice += "<tr>";

            prikaz_tablice += "<td>"+ log.stranica +"</td>";
            prikaz_tablice += "<td>"+ log.korisnik +"</td>";
            prikaz_tablice += "<td>"+ log.vrijeme +"</td>";

            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_tablicu_upit(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<thead>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Upit";
        prikaz_tablice += "<button class='silazno' data-stupac='s.naziv_upit'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='s.naziv_upit'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Korisnik";
        prikaz_tablice += "<button class='silazno' data-stupac='k.korisnicko_ime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.korisnicko_ime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Vrijeme";
        prikaz_tablice += "<button class='silazno' data-stupac='vrijeme'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='vrijeme'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "</tr>";
        prikaz_tablice += "</thead>";


        $.each(data.podaci, function (index, log) {

            prikaz_tablice += "<tr>";

            prikaz_tablice += "<td>"+ log.upit +"</td>";
            prikaz_tablice += "<td>"+ log.korisnik +"</td>";
            prikaz_tablice += "<td>"+ log.vrijeme +"</td>";

            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_tablicu_korisnik(data) {
        var tip = parseInt($("#tip").val());

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<thead>";
        prikaz_tablice += "<tr>";
        if(tip === 1){
            prikaz_tablice += "<th>";
            prikaz_tablice += "Stranica";
            prikaz_tablice += "<button class='silazno' data-stupac='s.naziv_stranica'>&#709;</button>"; //DESC
            prikaz_tablice += "<button class='uzlazno' data-stupac='s.naziv_stranica'>&#708;</button>"; //ASC
            prikaz_tablice += "</th>";
        }else {
            prikaz_tablice += "<th>";
            prikaz_tablice += "Upit";
            prikaz_tablice += "<button class='silazno' data-stupac='u.naziv_upit'>&#709;</button>"; //DESC
            prikaz_tablice += "<button class='uzlazno' data-stupac='u.naziv_upit'>&#708;</button>"; //ASC
            prikaz_tablice += "</th>";
        }
        prikaz_tablice += "<th>";
        prikaz_tablice += "Posjeti";
        prikaz_tablice += "<button class='silazno' data-stupac='posjecenost'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='posjecenost'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Ukupni udio";
        prikaz_tablice += "</th>";
        prikaz_tablice += "</tr>";
        prikaz_tablice += "</thead>";


        $.each(data.graf, function (index, log) {

            prikaz_tablice += "<tr>";

            if(tip === 1){
                prikaz_tablice += "<td>"+ log.stranica +"</td>";
            } else {
                prikaz_tablice += "<td>"+ log.upit +"</td>";
            }

            prikaz_tablice += "<td>"+ log.posjecenost +"</td>";
            var udio = Math.round( 100 * log.posjecenost / data.ukupna_posjecenost);
            prikaz_tablice += "<td>"+ udio +" %</td>";

            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function search(akcija,tip,interval){
        var prikaz_searcha = "<form method='post' action='src/statistike/statistika.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='tip' value='"+ tip +"'>";
        prikaz_searcha += "<input type='hidden' name='interval' value='"+ interval +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function sort(tip_sorta, stupac){
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }

        $.ajax({
            url: 'src/statistike/statistika.php',
            type: 'POST',
            data : {
                stupac : stupac,
                tip_sorta : tip_sorta,
                pojam : pojam,
                interval: $("#interval").val(),
                tip : $("#tip").val()
            },

            success: function (data) {
                data = JSON.parse(data);
                var tip = parseInt($("#tip").val());
                if(tip === 1){
                    $("#prikaz-tablice").html(nacrtaj_tablicu_stranica(data));
                }else{
                    $("#prikaz-tablice").html(nacrtaj_tablicu_upit(data));
                }

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
            url: "src/statistike/statistika.php",
            type: "POST",
            data: {
                aktivna_stranica: $(this).attr("data-stranica"),
                tip_sorta: $(this).attr("data-tip_sorta"),
                stupac: $(this).attr("data-stupac"),
                pojam: pojam,
                akcija: akcija,
                interval : $("#interval").val(),
                tip : $("#tip").val()
            },

            success: function (data) {
                data = JSON.parse(data);
                var tip = parseInt($("#tip").val());
                if(tip === 1){
                    $("#prikaz-tablice").html(nacrtaj_tablicu_stranica(data));
                }else{
                    $("#prikaz-tablice").html(nacrtaj_tablicu_upit(data));
                }
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

    $(document).on('change', '#interval', function () {
        pocetna();
    });

    $(document).on('change', '#tip', function () {
        pocetna();
    });

    $(document).on('click', '.print', function () {
        if($("#pojam").val() !== ""){
            $(".korisnik-statistika").html("Korisnik: " + $("#pojam").val());
            $(".legenda-graf2").css("display","none");
        }

        window.print();
        $(".legenda-graf2").css("display","inline");
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
                var pojam = $("#pojam").val();
                var tip = parseInt($("#tip").val());
                $("#poruke").html("").css("display","none");

                if( pojam === ""){
                    if( tip === 1){
                        $("#prikaz-tablice").html(nacrtaj_tablicu_stranica(data));
                    }else{
                        $("#prikaz-tablice").html(nacrtaj_tablicu_upit(data));
                    }

                }else{
                    $("#prikaz-tablice").html(nacrtaj_tablicu_korisnik(data));
                }

                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica,"",""));

                if(data.poruka){
                    $("#poruke").html(data.poruka).css("display","block");
                }

                $("#legenda").html("");

                var platno1 = document.getElementById("grafovi_statistika");

                platno1.width = 400;
                platno1.height = 400;

                var grafLajkova = new graf({
                    boje : ["BlueViolet","Brown","BurlyWood","CadetBlue","Coral","CornflowerBlue", "Cornsilk","Crimson"]
                });

                grafLajkova.crtaj(data.graf, data.ukupna_posjecenost, platno1);
            }
        });
    });

    var graf = function (opcije) {

        this.boje = opcije.boje;

        this.crtaj = function (datal, ukupno1, platno1) {

            var pocetni_kut1 = 0;
            var broj1, udio1;
            var ctx1 = platno1.getContext("2d");

            for(var i=0; i<datal.length; i++) {

                broj1 = datal[i]["posjecenost"];

                udio1 = 2 * Math.PI * broj1/ukupno1;

                var polumjer = Math.min(platno1.width/2, platno1.height/2);

                nacrtaj_udio(
                    ctx1,
                    platno1.width/2,
                    platno1.height/2,
                    polumjer,
                    pocetni_kut1,
                    pocetni_kut1+udio1,
                    this.boje[i]
                );

                var oznakax1 = platno1.width/2 + (50 + polumjer / 2) * Math.cos(pocetni_kut1 + udio1/2);
                var oznakay1 = platno1.height/2 + (50 + polumjer / 2) * Math.sin(pocetni_kut1+ udio1/2);

                var oznaka_postotak1 = Math.round( 100 * broj1 / ukupno1);
                ctx1.fillStyle = "white";
                ctx1.font = "bold 20px Arial";
                ctx1.fillText(oznaka_postotak1 + "%", oznakax1, oznakay1);

                pocetni_kut1 += udio1;

                var tip = parseInt($("#tip").val());
                var prikaz_legende = "<span class='legenda-graf2' " +
                    "style='background-color:"+ this.boje[i] +";'>&nbsp;</span>&nbsp;";
                if(tip === 1){
                    prikaz_legende += "<span class='legenda-graf2'>" + datal[i]["stranica"] + "</span><br/>";
                } else {
                    prikaz_legende += "<span class='legenda-graf2'>" + datal[i]["upit"] + "</span><br/>";
                }

                $("#legenda").append(prikaz_legende);
            }
        };
    };

    function nacrtaj_udio(ctx, centarx, centary, polumjer, pocetni_kut, zavrsni_kut, boja){

        ctx.fillStyle = boja;
        ctx.beginPath();
        ctx.moveTo(centarx, centary);
        ctx.arc(centarx, centary, polumjer, pocetni_kut, zavrsni_kut );
        ctx.closePath();
        ctx.fill();
    }

    $(document).on('submit',"#gen_pdf", function(event){

        event.preventDefault();

        $.ajax({

            url : "src/statistike/statistika.php",
            type : "POST",
            data : {
                pdf : 1,
                aktivna_stranica : $("#aktivan").attr("data-stranica"),
                interval : $("#interval").val(),
                tip : $("#tip").val(),
                pojam : $("#pojam").val(),
                stupac : $("#aktivan").attr("data-stupac"),
                tip_sorta : $("#aktivan").attr("data-tip_sorta")
            }

        });

    });

});