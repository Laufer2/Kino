<?php
require_once 'klase/baza.php';
require_once 'klase/datoteka.php';

function stranice_ispisa($tablica, $prikazi){

    $baza = new baza();

    $upit = "SELECT * FROM $tablica";
    $rezultat = $baza->selectdb($upit);

    $redovi = $rezultat->num_rows;

    if($redovi > $prikazi){ // potrebna paginacija

        $stranice = $redovi / $prikazi;
        return ceil($stranice);

    }else{
        return 0;
    }
}