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
    $id = filter_input(INPUT_POST,'id');
    $akcija = filter_input(INPUT_POST, 'akcija');
    $lokacija = filter_input(INPUT_POST,'lokacije');

    //$korisnik = $_SESSION['kino']->getIdKorisnik();
    $korisnik = 2;

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if(isset($_POST['selectmenu'])) {

        $json['lokacije'] = array();

        $upit = "SELECT * FROM lokacija JOIN moderatorlokacije m ON lokacija.id_lokacija = m.lokacija_id WHERE m.korisnik_id = $korisnik";

        $rezultat = $baza->selectdb($upit);

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red['id_lokacija'],
                "naziv" => $red['naziv_lokacija']
            );
            array_push($json['lokacije'], $polje);
        }

        $prva_lokacija = reset($json['lokacije']);
        $lokacija = intval(reset($prva_lokacija));
    }

    //potvrde i odbijanja rezervacija
    if(isset($_POST['id'])){
        if($_POST['id'] == 1) {
            $upit = "UPDATE rezervacija SET status = 1 WHERE id_rezervacija = $id";
        }else {
            $upit = "UPDATE rezervacija SET status = 0 WHERE id_rezervacija = $id";
        }
        $baza->update($upit);
    }

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM rezervacija r JOIN projekcija p ON r.projekcija_id = p.id_projekcija 
                  JOIN film f ON p.film_id = f.id_film JOIN lokacija l ON p.lokacija_id = l.id_lokacija WHERE r.korisnik_id = $korisnik AND 
                  (f.naziv_film LIKE '$pojam' OR l.naziv_lokacija LIKE '$pojam')";
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
        //$broj_stranica = stranice_ispisa("rezervacija", $prikazi);

        $upit = "SELECT f.naziv_film, k.korisnicko_ime, p.max_gledatelja, r.broj_rezervacija, f.godina, p.dostupan_do, r.id_rezervacija,
                  (SELECT (p.max_gledatelja - COUNT(*))  FROM rezervacija r WHERE r.status = 1 AND p.lokacija_id = $lokacija) as ostalo 
                  FROM rezervacija r JOIN projekcija p ON r.projekcija_id = p.id_projekcija
                  JOIN film f ON p.film_id = f.id_film JOIN korisnik k ON r.korisnik_id = k.id_korisnik 
                  WHERE r.status = 0 AND p.lokacija_id = $lokacija";

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

    $json['upit2']=$upit;

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "id" => $red['id_rezervacija'],
                "projekcija" => $red['naziv_film'] . " - " . " (" . $red['godina'] . ")" . " - " . date("j.m.Y, H:i", $red['dostupan_do']),
                "korisnik" => $red['korisnicko_ime'],
                "max" => $red['max_gledatelja'],
                "ostalo" => $red['ostalo'],
                "broj_rezervacija" => $red['broj_rezervacija'],
            );

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