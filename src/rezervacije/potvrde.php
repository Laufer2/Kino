<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';
require_once '../klase/korisnik.php';
require_once '../serverske_poruke.php';
require_once '../dnevnik_rada/dnevnik_rada.php';
require_once '../statistike/evidencija.php';

if(!isset($_SESSION))
{
    session_start();
}

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $id = filter_input(INPUT_POST,'id');
    $akcija = filter_input(INPUT_POST, 'akcija');
    $lokacija = filter_input(INPUT_POST,'lokacija');
    $mail = filter_input(INPUT_POST,'mail');
    $projekcija = filter_input(INPUT_POST,'projekcija');
    $korime = filter_input(INPUT_POST,'korisnik');
    $broj = filter_input(INPUT_POST,'broj');
    $vrijeme = filter_input(INPUT_POST,'vrijeme');

    $korisnik = $_SESSION['kino']->getIdKorisnik();

    dnevnik("Potvrde rezervacija", 3, 0);

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if(isset($_POST['selectmenu'])) {

        $json['lokacija'] = array();

        $upit = "SELECT * FROM lokacija JOIN moderatorlokacije m ON lokacija.id_lokacija = m.lokacija_id WHERE m.korisnik_id = $korisnik";
        dnevnik($upit, 2, 0);

        $rezultat = $baza->selectdb($upit);

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red['id_lokacija'],
                "naziv" => $red['naziv_lokacija']
            );
            array_push($json['lokacija'], $polje);
        }

        $prva_lokacija = reset($json['lokacija']);
        $lokacija = intval($prva_lokacija);
    }

    //potvrde i odbijanja rezervacija
    if(isset($_POST['id']) && isset($_POST['akcija'])){

        $naslov = "Rezervacija na Kino.org";
        $poruka = "Poštovani " . $korime . "<br/><br/>";
        $poruka .= "Rezervacija za projekciju: " . $projekcija . ", " . $vrijeme . ", broj rezervacija: " . $broj;

        if($akcija) {
            $upit = "UPDATE rezervacija SET status = 1 WHERE id_rezervacija = $id";
            dnevnik($upit, 2, 0);
            $poruka .= " - je potvrđena.";
            $json['poruka'] = "Korisnik je obaviješten o odobrenju rezervacije.";
        }else {
            $upit = "UPDATE rezervacija SET status = 2 WHERE id_rezervacija = $id";
            upit(2);
            $poruka .= " - je odbijena.";
            $json['poruka'] = "Korisnik je obaviješten o odbijanju rezervacije.";
        }
        $baza->update($upit);
        posalji_mail($mail, $naslov, $poruka);

    }

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT f.naziv_film, k.korisnicko_ime, p.max_gledatelja, r.broj_rezervacija, f.godina, p.dostupan_do, r.id_rezervacija, k.email,
                  (SELECT SUM(r.broj_rezervacija)  FROM rezervacija r WHERE r.status = 1 AND r.projekcija_id = p.id_projekcija) as ostalo
                  FROM rezervacija r JOIN projekcija p ON r.projekcija_id = p.id_projekcija
                  JOIN film f ON p.film_id = f.id_film JOIN korisnik k ON r.korisnik_id = k.id_korisnik 
                  WHERE r.status = 0 AND p.lokacija_id = $lokacija AND ( f.naziv_film LIKE '$pojam' OR k.korisnicko_ime LIKE '$pojam')";

    }else {

        $upit = "SELECT f.naziv_film, k.korisnicko_ime, p.max_gledatelja, r.broj_rezervacija, f.godina, p.dostupan_do, r.id_rezervacija, k.email,
                  (SELECT SUM(r.broj_rezervacija)  FROM rezervacija r WHERE r.status = 1 AND r.projekcija_id = p.id_projekcija) as ostalo 
                  FROM rezervacija r JOIN projekcija p ON r.projekcija_id = p.id_projekcija
                  JOIN film f ON p.film_id = f.id_film JOIN korisnik k ON r.korisnik_id = k.id_korisnik 
                  WHERE r.status = 0 AND p.lokacija_id = $lokacija";
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
        $json['poruka'] = "Nema podataka.";
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
                "id" => $red['id_rezervacija'],
                "mail" => $red['email'],
                "projekcija" => $red['naziv_film'] . " (" . $red['godina'] . ")",
                "vrijeme" => date("d.m.Y, H:i", $red['dostupan_do']),
                "korisnik" => $red['korisnicko_ime'],
                "max" => $red['max_gledatelja'],
                "ostalo" => intval($red['max_gledatelja'])-intval($red['ostalo']),
                "broj_rezervacija" => $red['broj_rezervacija'],
            );

            array_push($json['podaci'],$polje);
        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['lok'] = $lokacija;

    }else{

        $json['poruka'] = "Nema rezervacija za odobravanje.";
    }

    echo json_encode($json);
}