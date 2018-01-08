<?php

require_once 'baza.php';
require_once 'datoteka.php';

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST' && $_POST['rega'] == "Registriraj se"){

    $ime = htmlspecialchars(filter_input(INPUT_POST, 'ime', FILTER_SANITIZE_STRING));
    $prezime = htmlspecialchars(filter_input(INPUT_POST, 'prezime', FILTER_SANITIZE_STRING));
    $emial = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
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
        echo "Već postoji korisnički račun s navedenom e-mail adresom.";
    }

    if(strcmp($lozinka, $ponovljena_lozinka) != 0) {
        echo "Lozinke nisu jednake.";
    }

    if (strlen($korisnicko_ime) < 4){
        echo "Korisnicko ime mora imati min 4 znaka.";
    }

    /*lozinka mora imati veliko slovo te broj*/

    //generiraj aktivacijski kod

    $aktivacijski_kod = sha1($emial);

    //postavi aktivacijski rok ( s obzirom na trenutno postavljeno vrijeme )

    //postavi status aktivacije - po defaultu 0


    //postavi tip_id

    $tip_id = 3;

    //postavi neuspjesne prijave



    //posalji aktivacijski e-mail

}