<?php

    require_once 'baza.php';

    $korisnicko_ime = htmlspecialchars(filter_input(INPUT_GET,'korisnicko_ime',FILTER_SANITIZE_STRING));

    $upit = "SELECT id_korisnik FROM Korisnik WHERE korisnicko_ime = '$korisnicko_ime'";

    $baza = new baza();

    $rezultat = $baza->selectdb($upit);

    $polje = array("broj_redova" => $rezultat->num_rows);
    echo json_encode($polje);
