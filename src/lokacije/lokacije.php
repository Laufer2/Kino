<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';
require_once '../klase/korisnik.php';

session_start();

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    //$id = filter_input(INPUT_POST, 'id');
    $akcija = filter_input(INPUT_POST, 'akcija');

    //$korisnik = $_SESSION['kino']->getIdKorisnik();
    $korisnik = 2;
    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM lokacija JOIN adresa a ON lokacija.id_lokacija = a.lokacija_id JOIN drzava d ON a.drzava_id = d.id_drzava
                  JOIN grad g ON a.grad_id = g.id_grad JOIN lajkovi l ON lokacija.id_lokacija = l.lokacija_id WHERE 
                  (g.naziv_grad = '$pojam' OR d.naziv_drzava = '$pojam' OR a.ulica = '$pojam' OR l2.naziv_lokacija)";
        if(isset($stupac) && $stupac != "" ) {
            $upit .= " ORDER BY $stupac $tip_sorta";
            $json['tip_sorta'] = $tip_sorta;
            $json['stupac'] = $stupac;

        }else{
            $json['tip_sorta'] = "";
            $json['stupac'] = "";
        }
        $rezultat = $baza->selectdb($upit);
        $redovi = $rezultat->num_rows;
        if(!$redovi){
            $poruka = 1;
        }
        if ($rezultat > $prikazi){
            $broj_stranica = ceil($redovi/$prikazi);
        }else{
            $broj_stranica = 0;
        }

        //paginacija
        if($broj_stranica){
            $upit .= " LIMIT $prikazi OFFSET $offset";
        }
    }else {
        $broj_stranica = stranice_ispisa("lajkovi", $prikazi);

        $upit = "SELECT * FROM lokacija JOIN adresa a ON lokacija.id_lokacija = a.lokacija_id JOIN drzava d ON a.drzava_id = d.id_drzava
                  JOIN grad g ON a.grad_id = g.id_grad";
        if(isset($tip_sorta) && $tip_sorta != "" ) {
            $upit .= " ORDER BY $stupac $tip_sorta";
            $json['tip_sorta'] = $tip_sorta;
            $json['stupac'] = $stupac;
        }else{
            $json['tip_sorta'] = "";
            $json['stupac'] = "";
        }

        if($broj_stranica){
            $upit .= " LIMIT $prikazi OFFSET $offset";
        }

    }
    $json['upit'] = $upit;
    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "id" => $red['id_lokacija'],
                "lokacija" => $red['naziv_lokacija'],
                "grad" => $red['naziv_grad'],
                "ulica" => $red['ulica'] . " " . $red['broj'],
                "drzava" => $red['naziv_drzava'],
            );

            $lokacija = $red['id_lokacija'];

            // podupiti

            $u = "SELECT COUNT(*) FROM lajkovi WHERE lokacija_id=$lokacija AND svida_mi_se = 1";
            $rez = $baza->selectdb($u);
            $polje['lajkovi'] = $rez->fetch_array(MYSQLI_NUM);

            $u = "SELECT COUNT(*) FROM lajkovi WHERE lokacija_id=$lokacija AND svida_mi_se = 0";
            $rez = $baza->selectdb($u);
            $polje['ne_lajkovi'] = $rez->fetch_array(MYSQLI_NUM);

            array_push($json['podaci'],$polje);

        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['poruka'] = array('poruka'=>$poruka);

    }else{

        $poruka = 1;

        $json['poruka'] = array('poruka'=>$poruka);
    }

    echo json_encode($json);
}