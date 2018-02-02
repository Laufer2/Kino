$(document).ready( function () {

    "use strict";

    var podaciZaGraf;

    pocetna();

    function pocetna() {

        $.ajax({
            url : 'src/statistike/app_statistika.php',
            type : 'POST',
            data : {
                aktivna_stranica : 0,
                interval : $("#interval").val()
            },

            success: function (data) {
                data = JSON.parse(data);
                $("#prikaz-tablice").html(nacrtaj_tablicu(data));
                $("#paginacija").html(funkcija.paginacija(data.aktivna_stranica, data.broj_stranica, "", ""));

                $("#poruke").html(data.poruka);

                $("#legenda").html("");

                var platno1 = document.getElementById("udio_lajkova");

                platno1.width = 400;
                platno1.height = 400;

                var platno2 = document.getElementById("udio_nelajkova");

                platno2.width = 400;
                platno2.height = 400;

                var grafLajkova = new graf({
                    boje : ["BlueViolet","Brown","BurlyWood","CadetBlue","Coral","CornflowerBlue",
                        "Cornsilk","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGrey","DarkGreen",
                        "DarkKhaki","DarkMagenta","DarkOliveGreen","Darkorange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen",
                        "DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue",
                        "DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod",
                        "Grey","Green","GreenYellow","HoneyDew","HotPink","IndianRed","Indigo","Ivory","Khaki","Lavender",
                        "LavenderBlush","LawnGreen","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow",
                        "LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateGray",
                        "LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen","Linen","Magenta","Maroon","MediumAquaMarine",
                        "MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumSpringGreen","MediumTurquoise",
                        "MediumVioletRed","MidnightBlue","MintCream","MistyRose","Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab",
                        "Orange","OrangeRed","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff",
                        "Peru","Pink","Plum","PowderBlue","Purple","Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen",
                        "SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal",
                        "Thistle","Tomato","Turquoise","Violet","Wheat","Yellow","YellowGreen"]
                });

                grafLajkova.crtaj(data.graf, data.ukupno_lajkova, data.ukupno_nelajkova, platno1, platno2);

            }
        });
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Lokacija";
        prikaz_tablice += "<button class='silazno' data-stupac='l2.naziv_lokacija'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='l2.naziv_lokacija'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Sviđa mi se (ukupno)";
        prikaz_tablice += "<button class='silazno' data-stupac='broj_lajkova'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='broj_lajkova'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Ne sviđa mi se (ukupno)";
        prikaz_tablice += "<button class='silazno' data-stupac='broj_nelajkova'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='broj_nelajkova'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, log) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ log.lokacija +"</td>";
            prikaz_tablice += "<td>";
            prikaz_tablice += log.broj_lajkova;
            prikaz_tablice += " (" + data.ukupno_lajkova + ") ";
            prikaz_tablice += "</td>";

            prikaz_tablice += "<td>";
            prikaz_tablice += log.broj_nelajkova;
            prikaz_tablice += " (" + data.ukupno_nelajkova + ") ";
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
            url: 'src/statistike/app_statistika.php',
            type: 'POST',
            data : {
                stupac : stupac,
                tip_sorta : tip_sorta,
                pojam : pojam,
                akcija : akcija,
                interval: $("#interval").val()
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
            url: "src/statistike/app_statistika.php",
            type: "POST",
            data: {
                aktivna_stranica: $(this).attr("data-stranica"),
                tip_sorta: $(this).attr("data-tip_sorta"),
                stupac: $(this).attr("data-stupac"),
                pojam: pojam,
                akcija: akcija,
                interval : $("#interval").val()
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

    $(document).on('click', '#print', function () {
        window.print();
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

    var graf = function (opcije) {

        this.boje = opcije.boje;

        this.crtaj = function (datal, ukupno1, ukupno2, platno1, platno2) {

            var pocetni_kut1 = 0;
            var pocetni_kut2 = 0;
            var broj1, broj2, udio1, udio2;
            var ctx1 = platno1.getContext("2d");
            var ctx2 = platno2.getContext("2d");

            for(var i=0; i<datal.length; i++) {

                broj1 = datal[i]["broj_lajkova"];
                broj2 = datal[i]["broj_nelajkova"];

                udio1 = 2 * Math.PI * broj1/ukupno1;
                udio2 = 2 * Math.PI * broj2/ukupno2;

                var polumjer = Math.min(platno1.width/2, platno1.height/2);

                if(broj1 > 0){

                    nacrtaj_udio(
                        ctx1,
                        platno1.width/2,
                        platno2.height/2,
                        polumjer,
                        pocetni_kut1,
                        pocetni_kut1+udio1,
                        this.boje[i]
                    );

                    var oznakax1 = platno1.width/2 + (50 + polumjer / 2) * Math.cos(pocetni_kut1 + udio1/2);
                    var oznakay1= platno1.height/2 + (50 + polumjer / 2) * Math.sin(pocetni_kut1+ udio1/2);

                    var oznaka_postotak1 = Math.round( 100 * broj1 / ukupno1);
                    ctx1.fillStyle = "white";
                    ctx1.font = "bold 20px Arial";
                    ctx1.fillText(oznaka_postotak1 + "%", oznakax1, oznakay1);

                    pocetni_kut1 += udio1;
                }
                if(broj2 > 0){
                    nacrtaj_udio(
                        ctx2,
                        platno2.width/2,
                        platno2.height/2,
                        polumjer,
                        pocetni_kut2,
                        pocetni_kut2+udio2,
                        this.boje[i]
                    );

                    var oznakax2 = platno2.width/2 + (50 + polumjer / 2) * Math.cos(pocetni_kut2 + udio2/2);
                    var oznakay2 = platno1.height/2 + (50 + polumjer / 2) * Math.sin(pocetni_kut2+ udio2/2);

                    var oznaka_postotak2 = Math.round( 100 * broj2 / ukupno2);
                    ctx2.fillStyle = "white";
                    ctx2.font = "bold 20px Arial";
                    ctx2.fillText(oznaka_postotak2 + "%", oznakax2, oznakay2);

                    pocetni_kut2 += udio2;
                }

                var prikaz_legende = "<span style='display:inline-block;width:20px;background-color:"+ this.boje[i] +";'>&nbsp;</span>&nbsp;";
                prikaz_legende +=  datal[i]["lokacija"] + "<br/>";
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

});



