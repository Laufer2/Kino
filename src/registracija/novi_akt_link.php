<?php

require_once '../klase/baza.php';
require_once '../klase/datoteka.php';
require_once '../serverske_poruke.php';

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST'){

    $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    $dat = new datoteka();
    $sati = $dat->dohvati('rok_trajanja_aktivacijskog_linka');

    $pomak = $dat->dohvati('pomak');
    $akt_rok = time() + ($pomak*60*60) + ($sati * 60 * 60);

    $baza = new baza();
    $upit = "SELECT id_korisnik FROM korisnik WHERE email = '$email';";

    if($podaci = $baza->selectdb($upit)){
        $aktivacijski_kod = sha1($email . $akt_rok);
    }else{
        posalji_poruku("Ne postoji korisnički račun s tom e-mail adresom.");
        exit();
    }

    $upit = "UPDATE korisnik SET aktivacijski_rok = $akt_rok, aktivacijski_kod = '$aktivacijski_kod' WHERE email = '$email';";

    if($baza->update($upit)){
        //slanje novog akt maila

        $uri = $_SERVER["REQUEST_URI"];
        $pos = strrpos($uri, "/");
        $dir = $_SERVER["HTTP_HOST"] . substr($uri, 0, $pos - 16);
        $url = "http://" . $dir . "aktivacija.php?kod=$aktivacijski_kod";

        $naslov = "Novi aktivacijski link za Kino.org";
        $poruka = "Aktivirajte Vaš račun klikom na <a href='$url'>aktivacijski link.</a>";

        if(posalji_mail($email,$naslov,$poruka)){
            posalji_poruku("Aktivacijski link je poslan na vašu e-mail adresu. Račun možete aktivirati tokom $sati h.");
        }else{
            posalji_poruku("Greška kod slanja aktivacijskog linka. Pokušajte ponovo.");
        }
    }
}