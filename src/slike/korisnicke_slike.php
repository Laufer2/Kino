<?php

require_once '../klase/baza.php';
require_once '../klase/korisnik.php';
require_once '../dnevnik_rada/dnevnik_rada.php';


if(!isset($_SESSION))
{
    session_start();
}

$korisnik = $_SESSION['kino']->getIdKorisnik();
$admin = $_SESSION['kino']->getTipId();

$json = array();

$projekcija = filter_input(INPUT_POST,'projekcija');
$lokacija = filter_input(INPUT_POST,'lokacija');
$padajuci = filter_input(INPUT_POST,'padajuci');

$baza = new baza();

if(intval($padajuci) == 1 ) {

    $json['lokacije'] = array();

    $upit = "SELECT * FROM lokacija l JOIN moderatorlokacije m ON l.id_lokacija = m.lokacija_id WHERE korisnik_id = $korisnik";

    if ($admin == 1) {
        $upit = "SELECT * FROM lokacija";
    }

    $rezultat = $baza->selectdb($upit);

    if ($rezultat->num_rows) {
        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red['id_lokacija'],
                "naziv" => $red['naziv_lokacija']
            );
            array_push($json['lokacije'], $polje);
        }
    }

    echo json_encode($json);

}else if(intval($padajuci) == 2){


    $json['projekcije'] = array();

    $upit = "SELECT * FROM projekcija p JOIN film f ON p.film_id = f.id_film WHERE p.lokacija_id = $lokacija";
    $rezultat = $baza->selectdb($upit);

    if($rezultat->num_rows){
        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red['id_projekcija'],
                "naziv" => $red['naziv_film'] . " (" . $red['godina'] . ") - " . date("d.m.Y, H:i", $red['dostupan_do'])
            );
            array_push($json['projekcije'], $polje);
        }

        echo json_encode($json);
    }else{
        $json['projekcije'] = array();
        $json['poruka'] = 1;
        echo json_encode($json);
    }

}else{

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $akcija = filter_input(INPUT_POST, 'akcija');

    $korisnik = $_SESSION['kino']->getIdKorisnik();

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json['podaci'] = array();

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search
        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM rezervacija r JOIN slika s ON r.id_rezervacija = s.rezervacija_id
                  JOIN korisnik k ON r.korisnik_id = k.id_korisnik WHERE r.projekcija_id = $projekcija AND 
                  (k.ime LIKE '$pojam' OR k.prezime LIKE '$pojam')";

    }else{
        $upit = "SELECT * FROM rezervacija r JOIN slika s ON r.id_rezervacija = s.rezervacija_id
                  JOIN korisnik k ON r.korisnik_id = k.id_korisnik WHERE r.projekcija_id = $projekcija";
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

    if($broj_stranica){
        $upit .= " LIMIT $prikazi OFFSET $offset";
    }

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "ime" => $red['ime'],
                "prezime" => $red['prezime'],
            );

            array_push($json['podaci'],$polje);
        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['poruka'] = $poruka;

    }else{

        $poruka = 1;

        $json['poruka'] = $poruka;
    }

    echo json_encode($json);
}