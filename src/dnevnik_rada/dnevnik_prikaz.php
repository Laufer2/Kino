<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $id = filter_input(INPUT_POST, 'id');
    $akcija = filter_input(INPUT_POST, 'akcija');
    $tip = filter_input(INPUT_POST, 'tip');
    $interval = filter_input(INPUT_POST, 'interval');

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');
    $pomak = $dat->dohvati('pomak');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if(isset($id)){
        $upit = "DELETE FROM log WHERE id_log = $id ";
        $baza->update($upit);
    }

    //da se ne prikazuju zapisi iz "budućnosti

    $vrijeme = time() + ($pomak * 60 * 60) - ($interval * 60 * 60);
    $trenutno_vrijeme = time() + ($pomak * 60 * 60);

    if ($akcija == 5 && $pojam != ""){ // search
        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM log l JOIN korisnik k ON l.korisnik_id = k.id_korisnik WHERE l.vrijeme >= $vrijeme AND l.vrijeme <= $trenutno_vrijeme
                  AND (k.korisnicko_ime LIKE '$pojam' OR l.zapis LIKE '$pojam' OR l.skripta LIKE '$pojam')";
    }else {
        $upit = "SELECT * FROM log l JOIN korisnik k ON l.korisnik_id = k.id_korisnik WHERE l.vrijeme >= $vrijeme AND l.vrijeme <= $trenutno_vrijeme";
    }
    if ($tip < 4){
        $upit .= " AND l.tip = $tip ";
    }
    $json['upit'] = $upit;
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
        $poruka = "Nema podataka";
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

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "id" => $red['id_log'],
                "korisnik" => $red['korisnicko_ime'],
                "vrijeme" => date("j.m.Y, H:i", $red['vrijeme']),
                "ip_adresa" => $red['ip_adresa'],
                //"skripta" => $red['skripta'],
                "zapis" => $red['zapis'],
            );

            array_push($json['podaci'],$polje);
        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);

    }else{

        $poruka = 1;

        $json['poruka'] = $poruka;

        echo json_encode($json);

    }
}