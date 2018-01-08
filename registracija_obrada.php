<?php

require_once 'baza.php';
require_once 'datoteka.php';
require_once 'virtualno_vrijeme.php';
require_once 'serverske_poruke.php';

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST'){

    $ime = htmlspecialchars(filter_input(INPUT_POST, 'ime', FILTER_SANITIZE_STRING));
    $prezime = htmlspecialchars(filter_input(INPUT_POST, 'prezime', FILTER_SANITIZE_STRING));
    $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $korisnicko_ime = htmlspecialchars(filter_input(INPUT_POST, 'korime', FILTER_SANITIZE_STRING));
    $lozinka = htmlspecialchars(filter_input(INPUT_POST, 'lozinka', FILTER_SANITIZE_STRING));
    $ponovljena_lozinka = htmlspecialchars(filter_input(INPUT_POST, 'ponovo_lozinka', FILTER_SANITIZE_STRING));


    if(!preg_match("/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $email)){
        echo "Nepravilno strukturirana e-mail adresa.";
    }

    $upit = "SELECT * FROM Korisnik WHERE email = '$email';";
    $baza = new baza();

    $rezultat = $baza->selectdb($upit);
    if($rezultat->num_rows != 0){
        posalji_poruku( "Već postoji korisnički račun s navedenom e-mail adresom.");
        exit();
    }

    if(strcmp($lozinka, $ponovljena_lozinka) != 0) {
        posalji_poruku("Lozinke nisu jednake");
        exit();
    }

    if (strlen($korisnicko_ime) < 4){
        posalji_poruku("Korisnicko ime mora imati min 4 znaka.");
        exit();
    }

    /*lozinka mora imati veliko slovo te broj*/

    $aktivacijski_kod = sha1($email);

    //postavi aktivacijski rok ( s obzirom na trenutno postavljeno vrijeme )
    $datoteka = new datoteka();
    $rok_trajanja_aktivacijskog_koda = $datoteka->dohvati('rok_trajanja_aktivacijskog_koda');
    if($rok_trajanja_aktivacijskog_koda !== false){
        $aktivacijski_rok = time() + ($rok_trajanja_aktivacijskog_koda*60*60);
    }else{
        posalji_poruku("Nemoguće dohvatiti konfiguracijsku datoteku sustava.");
        exit();
    }

    //upiši podatke u bazu - tablica korisnik
    $upit = "INSERT INTO Korisnik(korisnicko_ime, lozinka, email, ime, prezime, aktivacijski_kod, aktivacijski_rok ) VALUES 
              ('$korisnicko_ime', '$lozinka', '$email', '$ime', '$prezime', '$aktivacijski_kod', '$aktivacijski_rok');";

    //slanje aktivacijskog mail-a

    if($baza->update($upit)){
        $naslov = "Molimo vas aktivirajte svoj račun";
        $poruka = "Uspješno ste se registrirali na Kino.org. <br/> <br/>"
            ."Vaše korisničko ime: $korisnicko_ime <br/>"
            ."Vaša lozinka: $lozinka <br/><br/>"
            //."Aktivirajte Vaš račun klikom na
            // <a href='http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x047/aktivacija.php?kod=$aktivacijski_kod'>aktivacijski link </a>."
            ."Aktivirajte Vaš račun klikom na <a href='localhost:8000/kino/aktivacija.php?kod=$aktivacijski_kod'>aktivacijski link.</a>";

        $header = "MIME-Version: 1.0" . "\r\n";
        $header .= "Content-type:text/html; charset=UTF-8" . "\r\n";
        $header .= "From: webmaster@kino.org" . "\r\n";

        if(mail($email, $naslov, $poruka, $header)){
            posalji_poruku("Uspješno ste se registrirali. Aktivacijski mail je poslan na '$email' <br>
                            Rok za aktivaciju vašeg računa iznosi '$rok_trajanja_aktivacijskog_koda'h.");
            // dodati zapis o uspješnoj registraciji u log
        }else{
            posalji_poruku("Aktivacijski mail nije poslan. Kontaktirajte administratora.");
        }
    }else{
        posalji_poruku("Pogreška prilikom upisa u bazu. Pokušajte ponovo.");
    }
}

