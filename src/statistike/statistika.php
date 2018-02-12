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
    $interval = filter_input(INPUT_POST, 'interval');
    $tip = filter_input(INPUT_POST, 'tip');
    $dapdf = filter_input(INPUT_POST, 'pdf');


    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');
    $pomak = $dat->dohvati('pomak');

    $poruka = $broj_stranica = 0;
    $db_stupac = $tablica = "";
    $json = array();

    $json['podaci'] = array();

    dnevnik("Statistika", 3, 0);

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    $trenutno_vrijeme = time() + ($pomak * 60 * 60);

    $proslo_vrijeme = time() + ($pomak * 60 * 60) - ($interval * 60 * 60);

    // ako nema pretrage
    if(!isset($pojam) || $pojam == "") {

        switch ($tip) {
            case 1: // prikaz stranica
                //glavni pregled
                // stranica - korisnik - vrijeme
                $upit = "SELECT * FROM stranica s JOIN korisnikstranica k ON s.id_stranica = k.stranica_id 
                      JOIN korisnik k2 ON k.korisnik_id = k2.id_korisnik WHERE k.vrijeme >= $proslo_vrijeme AND k.vrijeme <= $trenutno_vrijeme";
                $db_stupac = "naziv_stranica";
                $tablica = "stranica";

                $grafupit = "SELECT s.naziv_stranica,
                              (SELECT count(*) FROM korisnikstranica WHERE stranica_id = k.stranica_id 
                              AND vrijeme >= $proslo_vrijeme AND vrijeme <= $trenutno_vrijeme) as posjecenost
                              FROM korisnikstranica k JOIN stranica s ON k.stranica_id = s.id_stranica
                              WHERE k.vrijeme >= $proslo_vrijeme AND k.vrijeme <= $trenutno_vrijeme 
                              GROUP BY s.naziv_stranica";

                $grafstranica = graf($grafupit,$db_stupac,$tablica);
                $json['graf'] = $grafstranica;
                break;

            case 2: // prikaz upita
                $upit = "SELECT * FROM upit u JOIN korisnikupit k ON u.id_upit = k.upit_id 
                      JOIN korisnik k2 ON k.korisnik_id = k2.id_korisnik WHERE k.vrijeme >= $proslo_vrijeme AND k.vrijeme <= $trenutno_vrijeme";
                $db_stupac = "naziv_upit";
                $tablica = "upit";

                $grafupit = "SELECT u.naziv_upit,
                              (SELECT count(*) FROM korisnikupit WHERE upit_id = k.upit_id 
                              AND vrijeme >= $proslo_vrijeme AND vrijeme <= $trenutno_vrijeme) as posjecenost
                              FROM korisnikupit k JOIN upit u ON k.upit_id = u.id_upit
                              WHERE k.vrijeme >= $proslo_vrijeme AND k.vrijeme <= $trenutno_vrijeme 
                              GROUP BY u.naziv_upit";

                $grafupit = graf($grafupit,$db_stupac,$tablica);
                $json['graf'] = $grafupit;

        }

        if (isset($tip_sorta) && $tip_sorta != "") {
            $upit .= " ORDER BY $stupac $tip_sorta";
            $json['tip_sorta'] = $tip_sorta;
            $json['stupac'] = $stupac;
        } else {
            $json['tip_sorta'] = "";
            $json['stupac'] = "";
        }

        $json['upit'] = $upit;
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

        if($broj_stranica){
            $upit .= " LIMIT $prikazi OFFSET $offset";
        }

        $rezultat = $baza->selectdb($upit);

        if($rezultat->num_rows){

            while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

                $polje1 = array(
                    $tablica => $red[$db_stupac],
                    "korisnik" => $red['korisnicko_ime'],
                    "vrijeme" => date("d.m.Y, H:i", $red['vrijeme'])
                );

                array_push($json['podaci'],$polje1);
            }

            $json['aktivna_stranica'] = intval($aktivna_stranica);
            $json['broj_stranica'] = $broj_stranica;

        }else{

            $poruka = "Nema podataka.";

            $json['poruka'] = $poruka;
        }

        $posjecenost = 0;

        foreach ($json['graf'] as $element) {
            foreach ($element as $kljuc => $lajk) {
                if ($kljuc == "posjecenost") {
                    $posjecenost += $lajk;
                }
            }
        }

        $json['ukupna_posjecenost'] = $posjecenost;

    }else{ //pretraga = filter po korisniku

        $json['graf'] = array();

        switch ($tip) {
            case 1: // stranice - filter po korisniku
                // stranica - korisnikova posjećnost - sveukupna posjećenost

                $upit = "SELECT id_korisnik FROM korisnik JOIN korisnikstranica k ON korisnik.id_korisnik = k.korisnik_id
                          WHERE korisnicko_ime = '$pojam'";
                $rez = $baza->selectdb($upit);

                if($rez->num_rows) {
                    list($korisnik) = $rez->fetch_array();

                    $upit = "SELECT s.naziv_stranica,
                          (SELECT count(*) FROM korisnikstranica WHERE stranica_id = k.stranica_id 
                          AND vrijeme >= $proslo_vrijeme AND vrijeme <= $trenutno_vrijeme AND korisnik_id = $korisnik) as posjecenost
                          FROM korisnikstranica k JOIN stranica s ON k.stranica_id = s.id_stranica
                          WHERE k.vrijeme >= $proslo_vrijeme AND k.vrijeme <= $trenutno_vrijeme 
                          GROUP BY s.naziv_stranica";
                    $db_stupac = "naziv_stranica";
                    $tablica = "stranica";

                }else{

                    $poruka = "Nema podataka.";
                    $json['poruka'] = $poruka;

                }
                break;

            case 2: // upiti - filter po korisniku

                $upit = "SELECT id_korisnik FROM korisnik JOIN korisnikstranica k ON korisnik.id_korisnik = k.korisnik_id
                          WHERE korisnicko_ime = '$pojam'";
                $rez = $baza->selectdb($upit);

                if($rez->num_rows) {
                    list($korisnik) = $rez->fetch_array();

                    $upit = "SELECT u.naziv_upit,
                          (SELECT count(*) FROM korisnikupit WHERE upit_id = k.upit_id 
                          AND vrijeme >= $proslo_vrijeme AND vrijeme <= $trenutno_vrijeme AND korisnik_id = $korisnik) as posjecenost
                          FROM korisnikupit k JOIN upit u ON k.upit_id = u.id_upit
                          WHERE k.vrijeme >= $proslo_vrijeme AND k.vrijeme <= $trenutno_vrijeme 
                          GROUP BY u.naziv_upit";
                    $db_stupac = "naziv_upit";
                    $tablica = "upit";
                }else {
                    $poruka = "Nema podataka.";
                    $json['poruka'] = $poruka;
                }
        }

            if (isset($tip_sorta) && $tip_sorta != "") {
                $upit .= " ORDER BY $stupac $tip_sorta";
                $json['tip_sorta'] = $tip_sorta;
                $json['stupac'] = $stupac;
            } else {
                $json['tip_sorta'] = "";
                $json['stupac'] = "";
            }

            $rezultat = $baza->selectdb($upit);

            if($rezultat->num_rows){

                while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

                    $polje1 = array(
                        $tablica => $red[$db_stupac],
                        "posjecenost" => $red['posjecenost']
                    );

                    array_push($json['graf'],$polje1);
                }

            }else{

                $poruka = "Nema podataka.";
                $json['poruka'] = $poruka;
            }
    }

    $posjecenost = 0;
    foreach ($json['graf'] as $element) {
        foreach ($element as $kljuc => $lajk) {
            if ($kljuc == "posjecenost") {
                $posjecenost += $lajk;
            }
        }
    }

    $json['ukupna_posjecenost'] = $posjecenost;

    echo json_encode($json);
}

//graf podaci za sveukupni pregled
function graf ($upit, $db_stupac, $tablica){

    $b = new baza();
    $json= array();

    $rezultat = $b->selectdb($upit);
    if($rezultat->num_rows) {

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje1 = array(
                $tablica => $red[$db_stupac],
                "posjecenost" => $red['posjecenost']
            );

            array_push($json, $polje1);

        }

        return $json;
    }
    return array();
}