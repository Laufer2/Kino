<?php

require_once 'baza.php';

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST' && $_POST['rega'] == "Registriraj se"){

    $ime = htmlspecialchars(filter_input(INPUT_POST, 'ime', FILTER_SANITIZE_STRING));
    $prezime = htmlspecialchars(filter_input(INPUT_POST, 'prezime', FILTER_SANITIZE_STRING));
    $emial = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $korisnicko_ime = htmlspecialchars(filter_input(INPUT_POST, 'korime', FILTER_SANITIZE_STRING));
    $lozinka = htmlspecialchars(filter_input(INPUT_POST, 'lozinka', FILTER_SANITIZE_STRING));
    $ponovo_lozinka = htmlspecialchars(filter_input(INPUT_POST, 'ponovo_lozinka', FILTER_SANITIZE_STRING));


}