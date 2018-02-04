<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';
require_once '../dnevnik_rada/dnevnik_rada.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $akcija = filter_input(INPUT_POST, 'akcija');
    $ispis = filter_input(INPUT_POST,'ispis');
    $interval = filter_input(INPUT_POST, 'interval');


    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');
    $pomak = $dat->dohvati('pomak');

    $poruka = $broj_stranica = 0;
    $json = array();

    $json['podaci'] = array();
    $json['graf'] = array();
    dnevnik("Aplikativna statistika", 3, 0);

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    $trenutno_vrijeme = time() + ($pomak * 60 * 60);

    $vrijeme = time() + ($pomak * 60 * 60) - ($interval * 60 * 60);


    $upit = "SELECT l2.naziv_lokacija,
              (SELECT count(*) FROM lajkovi WHERE lajkovi.lokacija_id = l.lokacija_id AND svida_mi_se = 1 AND vrijeme >= $vrijeme AND vrijeme <= $trenutno_vrijeme) as broj_lajkova,
              (SELECT count(*) FROM lajkovi WHERE lajkovi.lokacija_id = l.lokacija_id AND svida_mi_se = 0 AND vrijeme >= $vrijeme AND vrijeme <= $trenutno_vrijeme) as broj_nelajkova
              FROM lajkovi l JOIN lokacija l2 ON l.lokacija_id = l2.id_lokacija WHERE l.vrijeme >= $vrijeme AND l.vrijeme <= $trenutno_vrijeme 
              GROUP BY l2.naziv_lokacija";
    dnevnik($upit, 2, 0);

    $rezultat = $baza->selectdb($upit);

    while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

        $polje2 = array(
            "lokacija" => $red['naziv_lokacija'],
            "broj_lajkova" => $red['broj_lajkova'],
            "broj_nelajkova" => $red['broj_nelajkova']
        );
        array_push($json['graf'],$polje2);
    }

    $broj_lajkova = $broj_nelajkova = 0;

    foreach ($json['graf'] as $element) {
        foreach ($element as $kljuc => $lajk) {
            if ($kljuc == "broj_lajkova") {
                $broj_lajkova += $lajk;
            }
            if ($kljuc == "broj_nelajkova") {
                $broj_nelajkova += $lajk;
            }
        }
    }

    $json['ukupno_lajkova'] = $broj_lajkova;
    $json['ukupno_nelajkova'] = $broj_nelajkova;


    if(isset($tip_sorta) && $tip_sorta != "" ) {
        $upit .= " ORDER BY $stupac $tip_sorta";
        $json['tip_sorta'] = $tip_sorta;
        $json['stupac'] = $stupac;

    }else{
        $json['tip_sorta'] = "";
        $json['stupac'] = "";
    }

    $redovi = $rezultat->num_rows;
    if(!$redovi){
        $poruka = 1;
    }
    if ($rezultat > $prikazi){
        $broj_stranica = ceil($redovi/$prikazi);
    }else{
        $broj_stranica = 0;
    }

    if($broj_stranica && !isset($ispis)){
        $upit .= " LIMIT $prikazi OFFSET $offset";
    }

    $rezultat = $baza->selectdb($upit);
    if($rezultat->num_rows){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje1 = array(
                "lokacija" => $red['naziv_lokacija'],
                "broj_lajkova" => $red['broj_lajkova'],
                "broj_nelajkova" => $red['broj_nelajkova']
            );

            array_push($json['podaci'],$polje1);

        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['poruka'] = array('poruka'=>$poruka);

    }else{

        $poruka = "Nema podataka.";

        $json['poruka'] = $poruka;
    }

    echo json_encode($json);
}