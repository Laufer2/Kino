<?php

require_once '../klase/baza.php';
require_once '../klase/datoteka.php';
require_once '../serverske_poruke.php';
require_once '../stranice_ispisa.php';

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST') {

    $sortiranje = filter_input(INPUT_POST, 'sortiranje');
    $broj_stranice = filter_input(INPUT_POST, 'broj_stranice');
    $stupac = filter_input(INPUT_POST, 'stupac');

    if($stupac == 1){
        $stupac = 'l.naziv_lokacije';
    }else{
        $stupac = 'g.naziv_grada';
    }


    $upit = "SELECT l.naziv_lokacije, a.ulica, a.broj, g.naziv_grada, d.naziv_drzave FROM lokacija l JOIN adresa a ON 
              l.id_lokacija = a.lokacija_id JOIN drzava d ON a.drzava_id = d.id_drzava JOIN grad g ON a.grad_id = g.id_grad";

    $baza = new baza();

    if($podaci = $baza->selectdb($upit)){

        $broj_redova = $podaci->num_rows;
        $dat = new datoteka();
        $prikazi = $dat->dohvati('broj_prikaza_po_stranici');
        $ukupno_stranica = stranice_ispisa($broj_redova, $prikazi);
        if($ukupno_stranica > 1) {

            // 2-DESC, 1-ASC
            switch ($sortiranje){
                case 2:
                    $upit = "SELECT l.naziv_lokacije, a.ulica, a.broj, g.naziv_grada, d.naziv_drzave FROM lokacija l JOIN adresa a ON 
                    l.id_lokacija = a.lokacija_id JOIN drzava d ON a.drzava_id = d.id_drzava JOIN grad g ON a.grad_id = g.id_grad
                    ORDER BY '$stupac' DESC LIMIT $prikazi OFFSET $prikazi*$broj_stranice";
                    break;
                case 1:
                    $upit = "SELECT l.naziv_lokacije, a.ulica, a.broj, g.naziv_grada, d.naziv_drzave FROM lokacija l JOIN adresa a ON 
                    l.id_lokacija = a.lokacija_id JOIN drzava d ON a.drzava_id = d.id_drzava JOIN grad g ON a.grad_id = g.id_grad
                    ORDER BY '$sutpac' ASC LIMIT $prikazi OFFSET $prikazi*$broj_stranice";
                    break;
                default:
                    $upit = "SELECT l.naziv_lokacije, a.ulica, a.broj, g.naziv_grada, d.naziv_drzave FROM lokacija l JOIN adresa a ON 
                    l.id_lokacija = a.lokacija_id JOIN drzava d ON a.drzava_id = d.id_drzava JOIN grad g ON a.grad_id = g.id_grad
                    LIMIT $prikazi OFFSET $prikazi*$broj_stranice";
            }


            $podaci = $baza->selectdb($upit);
        }

        $polje = $podaci->fetch_array();

        //mora se poslati ukupni_broj_stranica i podaci za prikaz

    }else{
        echo "Nema podataka.";
    }


}