<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $idk = filter_input(INPUT_POST, 'idk');
    $idl = filter_input(INPUT_POST, 'idl');
    $akcija = filter_input(INPUT_POST, 'akcija');
    $selectmenu = filter_input(INPUT_POST,'selectmenu');

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    //novi zapis
    if($akcija < 4) {

        $upit = filter_input(INPUT_POST, 'kupit');
        $korisnik = filter_input(INPUT_POST, 'korisnik');
        $vrijeme2 = filter_input(INPUT_POST, 'vrijeme');
        $datum1 = filter_input(INPUT_POST,'datum1');
        $sati1 = filter_input(INPUT_POST,'sati1');
        $minute1 = filter_input(INPUT_POST,'minute1');

        $dat1 = strtotime($datum1);
        $vrijeme = $dat1 + ($sati1*60*60) + ($minute1 * 60);

    }

    // padajući meniji za vanjske ključeve
    if ($selectmenu){

        $tablice = $_POST['tablica'];

        foreach($tablice as $tablica) {

            $db_id = "id_" . $tablica;

            $upit = "SELECT * FROM $tablica";

            $rezultat = $baza->selectdb($upit);

            if($tablica == "korisnik"){
                $db_stupac = "korisnicko_ime";
            }else{
                $db_stupac = "naziv_" . $tablica;
            }

            $json[$tablica] = array();

            while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

                $polje = array(
                    "id" => $red[$db_id],
                    "naziv" => $red[$db_stupac]
                );

                array_push($json[$tablica], $polje);
            }
        }
    }

    switch ($akcija){
        case 1://kreiranje
            $upit = "SELECT * FROM korisnikupit WHERE upit_id = $upit AND korisnik_id = $korisnik AND vrijeme = $vrijeme";
            $rezultat = $baza->selectdb($upit);

            if($rezultat->num_rows){
                $poruka = "Taj zapis već postoji";
            }else{
                $upit = "INSERT INTO korisnikupit VALUES ($korisnik, $upit, $vrijeme)";
                $rezultat = $baza->update($upit);
            }
            break;

        case 3: // brisanje
            $upit = "DELETE FROM korisnikstranica WHERE korisnik_id = $idk AND stranica_id = $idl and vrijeme = $vrijeme2";
            $rezultat = $baza->selectdb($upit);
            break;

    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM korisnikupit k JOIN korisnik k2 ON k.korisnik_id = k2.id_korisnik JOIN upit u ON k.upit_id = u.id_upit
                  WHERE k2.korisnicko_ime LIKE '$pojam' OR u.naziv_upit LIKE '$pojam'";

    }else {

        $upit = "SELECT * FROM korisnikupit k JOIN korisnik k2 ON k.korisnik_id = k2.id_korisnik JOIN upit u ON k.upit_id = u.id_upit";

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

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "idl" => $red['upit_id'],
                "idk" => $red['korisnik_id'],
                "upit" => $red['naziv_upit'],
                "korisnik" => $red['korisnicko_ime'],
                "vrijeme" => date("j.m.Y, H:i", $red['vrijeme']),
                "vrijeme2" =>  $red['vrijeme']
            );

            array_push($json['podaci'],$polje);
        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);

    }else{

        $poruka = 1;

        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);

    }
}