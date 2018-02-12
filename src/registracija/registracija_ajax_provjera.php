<?php

    require_once '../klase/baza.php';

    if (filter_has_var(INPUT_GET, 'email')){

        $email = htmlspecialchars(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING));

        $upit = "SELECT * FROM korisnik WHERE email = '$email'";


    }else{

        $korisnicko_ime = htmlspecialchars(filter_input(INPUT_GET, 'korisnicko_ime', FILTER_SANITIZE_STRING));

        $upit = "SELECT id_korisnik FROM korisnik WHERE korisnicko_ime = '$korisnicko_ime';";

    }

    $baza = new baza();

    $rezultat = $baza->selectdb($upit);

    $polje = array("broj_redova" => $rezultat->num_rows);

    echo json_encode($polje);


