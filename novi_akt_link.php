<?php

require_once 'baza.php';
require_once 'virtualno_vrijeme.php';
require_once 'datoteka.php';
require_once 'serverske_poruke.php';

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST'){

    $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    $dat = new datoteka();
    $sati = $dat->dohvati('rok_trajanja_aktivacijskog_koda');

    $vrijeme = new virtualno_vrijeme($dat);
    $pomak = $vrijeme->dohvati();
    $akt_rok = time() + $pomak + ($sati * 60 * 60);

    $baza = new baza();
    $upit = "SELECT aktivacijski_kod FROM korisnik WHERE email = '$email';";
    if($podaci = $baza->selectdb($upit)){
        $akt_kod = $podaci->fetch_array();
        $aktivacijski_kod = $akt_kod['aktivacijski_kod'];
    }else{
        posalji_poruku("Ne postoji korisnički račun s tom e-mail adresom.");
        exit();
    }

    $upit = "UPDATE korisnik SET aktivacijski_rok = $akt_rok WHERE email = '$email';";

    if($baza->update($upit)){
        //slanje novog akt maila
        $naslov = "Novi aktivacijski link za Kino.org";
        //$poruka = "Aktivirajte Vaš račun klikom na <a href='http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x047/aktivacija.php?kod=$aktivacijski_kod'>aktivacijski link </a>";
        $poruka = "Aktivirajte Vaš račun klikom na <a href='http://localhost:8000/kino/aktivacija.php?kod=$aktivacijski_kod'>aktivacijski link.</a>";

        if(posalji_mail($email,$naslov,$poruka)){
            posalji_poruku("Aktivacijski link je poslan na vašu e-mail adresu. Račun možete aktivirati u sljedećih $sati h.");
        }else{
            posalji_poruku("Greška kod slanja aktivacijskog linka. Pokušajte ponovo.");
        }

    }
}