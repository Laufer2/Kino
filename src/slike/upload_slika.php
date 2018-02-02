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
    $akcija = filter_input(INPUT_POST, 'akcija');

    $baza = new baza();
    $dat = new datoteka();

    $korisnik = $_SESSION['kino']->getIdKorisnik();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM rezervacija r JOIN slika s ON r.id_rezervacija = s.rezervacija_id
                  JOIN projekcija p ON r.projekcija_id = p.id_projekcija JOIN film f ON p.film_id = f.id_film
                  JOIN lokacija l ON p.lokacija_id = l.id_lokacija
                  WHERE  r.korisnik_id = $korisnik AND s.rezervacija_id != r.id_rezervacija AND r.status = 1 AND 
                  (f.naziv_film LIKE '$pojam' OR l.naziv_lokacija LIKE '$pojam')";

    }else {
        $upit = "SELECT * FROM rezervacija r 
                  JOIN projekcija p ON r.projekcija_id = p.id_projekcija JOIN film f ON p.film_id = f.id_film
                  JOIN lokacija l ON p.lokacija_id = l.id_lokacija
                  WHERE  r.korisnik_id = $korisnik  AND r.status = 1";
    }

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

    $json['upit']=$upit;

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "id" => $red['id_rezervacija'],
                "film" => $red['naziv_film'] . " (" . $red['godina'] . ") ",
                "lokacija" => $red['naziv_lokacija'],
                "broj_rezervacija" => $red['broj_rezervacija'],
                "vrijeme" => date("d.m.Y, H:i", $red['dostupan_do'])
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