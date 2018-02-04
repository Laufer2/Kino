<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';
require_once '../klase/korisnik.php';
require_once '../dnevnik_rada/dnevnik_rada.php';
require_once '../statistike/evidencija.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    //$id = filter_input(INPUT_POST, 'id');
    $akcija = filter_input(INPUT_POST, 'akcija');

    dnevnik("Lokacije", 3, 0);
    stranica(1);

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM lokacija l JOIN adresa a ON l.id_lokacija = a.lokacija_id JOIN drzava d ON a.drzava_id = d.id_drzava
                  JOIN grad g ON a.grad_id = g.id_grad JOIN lajkovi l2 ON l.id_lokacija = l2.lokacija_id WHERE 
                  (g.naziv_grad = '$pojam' OR d.naziv_drzava = '$pojam' OR a.ulica = '$pojam' OR l.naziv_lokacija)";

    }else {

        $upit = "SELECT * FROM lokacija l JOIN adresa a ON l.id_lokacija = a.lokacija_id JOIN drzava d ON a.drzava_id = d.id_drzava
                  JOIN grad g ON a.grad_id = g.id_grad";
        dnevnik($upit, 2, 0);

    }
    if(isset($tip_sorta) && $tip_sorta != "" ) {
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

    $json['upit'] = $upit;

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "id" => $red['id_lokacija'],
                "lokacija" => $red['naziv_lokacija'],
                "grad" => $red['naziv_grad'],
                "ulica" => $red['ulica'] . " " . $red['broj'] . ", " . $red['postanski_broj'],
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