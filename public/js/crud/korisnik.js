$(document).ready( function(){
    "use strict";
    var polje_validacija = [0,0,0,0];

    $.ajax({
        url : 'src/crud/korisnik.php',
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
        var prikaz_searcha = "<form method='post' action='src/crud/korisnik.php' id='pretraga' enctype='application/x-www-form-urlencoded'>";
        prikaz_searcha += "<input type='text' name='pojam' id='pojam'>";
        prikaz_searcha += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_searcha += "<input type='submit' value='P'>";
        prikaz_searcha += "</form>";

        return prikaz_searcha;
    }

    function nacrtaj_tablicu(data) {

        var prikaz_tablice = "<button id='gumb-kreiraj'>";
        prikaz_tablice += "Dodaj novi zapis";
        prikaz_tablice += "</button>";

        prikaz_tablice += "<table class='tablica'>";
        prikaz_tablice += "<tr>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Korisničko ime";
        prikaz_tablice += "<button class='silazno' data-stupac='k.korisnicko_ime'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='k.korisnicko_ime'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>";
        prikaz_tablice += "Tip korisnika";
        prikaz_tablice += "<button class='silazno' data-stupac='t.naziv_tipkorisnika'>&#709;</button>"; //DESC
        prikaz_tablice += "<button class='uzlazno' data-stupac='t.naziv_tipkorisnika'>&#708;</button>"; //ASC
        prikaz_tablice += "</th>";
        prikaz_tablice += "<th>Ime</th>";
        prikaz_tablice += "<th>Prezime</th>";
        prikaz_tablice += "<th>E-mail</th>";
        prikaz_tablice += "<th>Status aktivacije</th>";
        prikaz_tablice += "<th>Neuspješne prijave</th>";
        prikaz_tablice += "<th>Lozinka</th>";
        prikaz_tablice += "<th>Aktivacijski rok</th>";
        //prikaz_tablice += "<th>Aktivacijski kod</th>";
        prikaz_tablice += "<th>Funkcije</th>";
        prikaz_tablice += "</tr>";

        $.each(data.podaci, function (index, korisnik) {

            prikaz_tablice += "<tr>";
            prikaz_tablice += "<td>"+ korisnik.korisnicko +"</td>";
            prikaz_tablice += "<td>"+ korisnik.tipkorisnika +"</td>";
            prikaz_tablice += "<td>"+ korisnik.ime +"</td>";
            prikaz_tablice += "<td>"+ korisnik.prezime +"</td>";
            prikaz_tablice += "<td>"+ korisnik.email +"</td>";
            prikaz_tablice += "<td>"+ korisnik.status +"</td>";
            prikaz_tablice += "<td>"+ korisnik.neuspjesne_prijave +"</td>";
            prikaz_tablice += "<td>"+ korisnik.lozinka +"</td>";
            prikaz_tablice += "<td>"+ korisnik.akt_rok +"</td>";
            //prikaz_tablice += "<td>"+ korisnik.akt_kod +"</td>";

            prikaz_tablice += "<td>";
            prikaz_tablice += "<button class='gumb-edit' data-id='"+ korisnik.id +"'>Uredi</button>";
            prikaz_tablice += "<button class='gumb-delete' data-id='"+ korisnik.id +"'>Izbriši</button>";
            prikaz_tablice += "<button class='gumb-block' data-id='"+ korisnik.id +"'>Zaključaj</button>";
            prikaz_tablice += "</td>";
            prikaz_tablice += "</tr>";

        });

        prikaz_tablice += "</table>";
        return prikaz_tablice;
    }

    function nacrtaj_formu(lista, akcija, id) {

        var prikaz_forme = "<form action='src/crud/korisnik.php' ";
        prikaz_forme += "id='novi_zapis' method='post' enctype='application/x-www-form-urlencoded'>";

        prikaz_forme += "<label for='korisnicko'>Korisničko ime</label>";
        prikaz_forme += "<input type='text' name='korisnicko' id='korisnicko' required>";
        prikaz_forme += "<span id='korisnicko_poruka'></span>";
        prikaz_forme += "<br/>";

        prikaz_forme += "<label for='tipkorisnika'>Tip korisnika</label>";
        prikaz_forme += "<select name='tipkorisnika' id='tipkorisnika'>";
        $.each(lista.tipkorisnika, function (index, val) {

            prikaz_forme += "<option value='"+ val.id +"'>"+ val.naziv +"</option>";
        });
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='ime'>Ime</label>";
        prikaz_forme += "<input type='text' name='ime' id='ime' required><br/>";

        prikaz_forme += "<label for='prezime'>Prezime</label>";
        prikaz_forme += "<input type='text' name='prezime' id='prezime' required><br/>";

        prikaz_forme += "<label for='email'>E-mail</label>";
        prikaz_forme += "<input type='text' name='email' id='email' required>";
        prikaz_forme += "<span id='email_poruka'></span>";
        prikaz_forme += "<br/>";

        prikaz_forme += "<label for='lozinka'>Lozinka</label>";
        prikaz_forme += "<input type='text' name='lozinka' id='lozinka' required><br/>";

        prikaz_forme += "<label for='status'>Status aktivacije</label>";
        prikaz_forme += "<select name='status' id='status'>";
        prikaz_forme += "<option value='0'>Neaktiviran</option>";
        prikaz_forme += "<option value='1'>Aktiviran</option>";
        prikaz_forme += "<option value='2'>Zaključan</option>";
        prikaz_forme += "</select><br/>";

        prikaz_forme += "<label for='neuspjesne_prijave'>Neuspješne prijave</label>";
        prikaz_forme += "<input type='number' name='neuspjesne_prijave' id='neuspjesne_prijave' required><br/>";

        prikaz_forme += "<input type='hidden' name='akcija' value='"+ akcija +"'>";
        prikaz_forme += "<input type='hidden' name='id' value='"+ id +"'>";

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
            url: 'src/crud/korisnik.php',
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

    $(document).on('blur', '#email', function () {
        var vazeci_email = false;
        if($(this).val().length !== 0) {
            var email = $("#email").val();
            //preuzeto s emailregex.com
            var regex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if(!regex.test(email)){
                polje_validacija[0] = 0;
                $("#email_poruka").html("Nevazeca struktura e-mail adrese.");
                vazeci_email = false;
            }else{
                polje_validacija[0] = 1;
                $("#email_poruka").html("");
                vazeci_email = true;
            }
            if(vazeci_email){
                $.ajax({
                    type: "GET",
                    datatype: "JSON",
                    url: "src/registracija/registracija_ajax_provjera.php",
                    data: {
                        'email': $(this).val()
                    },
                    success: function (data) {
                        var polje = JSON.parse(data);
                        if (polje["broj_redova"] > 0) {
                            $("#email_poruka").html("Postoji korisnik s tom e-mail adresom");
                            polje_validacija[3] = 0;
                        } else {
                            $("#email_poruka").html("");
                            polje_validacija[3] = 1;
                        }
                    },
                    error: function () {
                        $("#email_poruka").html("Greska prilikom provjere korisnickog imena.");
                        $("input[type='submit']").css("display", "none");
                    }
                });
            }
        }

    });

    $(document).on('blur', '#korisnicko', function() {

        if($(this).val().length !== 0){
            if ($(this).val().length < 4) {
                polje_validacija[2] = 0;
                $("#korisnicko_poruka").html("Min 4 znaka u korisnickom imenu.");
            } else {
                polje_validacija[2] = 1;

                $.ajax({
                    type: "GET",
                    datatype: "JSON",
                    url: "src/registracija/registracija_ajax_provjera.php",
                    data: {
                        'korisnicko_ime': $(this).val()
                    },
                    success: function (data) {
                        var polje = JSON.parse(data);
                        if (polje["broj_redova"] > 0) {
                            $("#korisnicko_poruka").html("Zauzeto korisnicko ime.");
                            polje_validacija[1] = 0;
                        } else {
                            $("#korisnicko_poruka").html("OK");
                            polje_validacija[1] = 1;
                        }
                    },
                    error: function () {
                        $("#korisnicko_poruka").html("Greska prilikom provjere korisnickog imena.");
                    }
                });
            }
        }
    });

    $(document).on('click', '.gumb-block', function(){
        var id = $(this).attr("data-id");
        $("#meni-statusa").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Promijeni status": function() {
                    var status = $(this).val();
                    $.ajax({
                        url: 'src/crud/korisnik.php',
                        type: 'POST',
                        data: {
                            id : id,
                            status: status,
                            akcija : 6
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

    $(document).on('click', '.broj-paginacija', function () {
        var pojam, akcija="";
        if($("#pojam").val() !== ""){
            pojam = $("#pojam").val();
            akcija = 5;
        }
        $.ajax({
            url: "src/crud/korisnik.php",
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
                        url: 'src/crud/korisnik.php',
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
        var tablice = ["tipkorisnika"];

        $.ajax({
            url: 'src/crud/korisnik.php',
            type: 'POST',
            data: {
                id: id,
                akcija: 4,
                selectmenu : 1,
                tablica : tablice
            },

            success: function (data) {
                var lista = JSON.parse(data);
                $("#forma").html( nacrtaj_formu(lista, 2, 2));

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
        var tablice = ["tipkorisnika"];

        $.ajax({
            url : 'src/crud/korisnik.php',
            type : 'POST',
            data : {
                tablica : tablice,
                selectmenu : 1
            },

            success: function (data) {
                var lista = JSON.parse(data);
                $("#forma").html( nacrtaj_formu(lista, 1 ,0));
            }
        });
    });

    $(document).on('submit', '#novi_zapis', function(event) {

        var forma = $("#novi_zapis");
        event.preventDefault();

        /*
        if(!funkcija.validacija(polje_validacija)){
            return false;
        }
        */
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