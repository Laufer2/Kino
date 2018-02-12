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
    $selectmenu = filter_input(INPUT_POST,'selectmenu');
    $id_projekcija = filter_input(INPUT_POST,'id_projekcija');

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = $status = 0;
    $json = array();
    $json['podaci'] = array();

    //novi zapis
    if($akcija < 3) {

        $projekcija = filter_input(INPUT_POST, 'projekcija');
        $korisnik = filter_input(INPUT_POST, 'korisnik');
        $broj_rezervacija = filter_input(INPUT_POST, 'broj_rezervacija');
        $status = filter_input(INPUT_POST, 'status');
    }

    // padajući meniji za vanjske ključeve
    if ($selectmenu){

        $upit = "SELECT * FROM korisnik";

        $rezultat = $baza->selectdb($upit);

        $json['korisnik'] = array();

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red['id_korisnik'],
                "naziv" => $red['korisnicko_ime']
            );

            array_push($json['korisnik'], $polje);
        }


        $json['projekcija'] = array();

        $upit = "SELECT * FROM projekcija 
                  JOIN film f ON projekcija.film_id = f.id_film JOIN lokacija l ON projekcija.lokacija_id = l.id_lokacija ";

        // rezervacije samo za one projekcije koje nisu prošle - uspoređujući s virtualnim vremenom
        $rezultat = $baza->selectdb($upit);
        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red['id_projekcija'],
                "naziv" => $red["naziv_film"] . " - " . date("j.m.Y, H:i", $red['dostupan_do']) . " - " . $red['naziv_lokacija']
            );

            array_push($json['projekcija'], $polje);
        }

    }

    switch ($akcija){
        case 1://kreiranje

            $upit = "INSERT INTO rezervacija VALUES (default, $broj_rezervacija ,$status, $korisnik, $projekcija)";
            $rezultat = $baza->update($upit);
            $json['upit'] = $upit;
            break;

        case 2:// ažuriranje

            $upit = "UPDATE rezervacija SET projekcija_id = $projekcija, korisnik_id = $korisnik, broj_rezervacija = $broj_rezervacija,  
                     status = $status WHERE id_rezervacija = $id";
            $rezultat = $baza->update($upit);
            break;

        case 3: // brisanje
            $upit = "DELETE FROM rezervacija WHERE id_rezervacija = $id";
            $rezultat = $baza->update($upit);
            break;

        case 4: //dohvati jednoga za ažuriranje  -- poseno za projekciju
            $upit = "SELECT * FROM rezervacija WHERE id_rezervacija = $id";
            $rezultat = $baza->selectdb($upit);

            list($id, $broj_rezervacija, $status, $korisnik, $projekcija ) = $rezultat->fetch_array();
            $polje = array(
                "id" => $id,
                "korisnik" => $korisnik,
                "broj_rezervacija" => $broj_rezervacija,
                "status" => $status,
                "projekcija" => $id_projekcija
            );
            array_push($json['podaci'],$polje);
            echo json_encode($json);
            exit();
    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM rezervacija r JOIN korisnik k ON r.korisnik_id = k.id_korisnik JOIN projekcija p ON r.projekcija_id = p.id_projekcija 
                  JOIN film f ON p.film_id = f.id_film JOIN lokacija l ON p.lokacija_id = l.id_lokacija WHERE k.korisnicko_ime LIKE '$pojam' OR 
                  f.naziv_film LIKE '$pojam' OR l.naziv_lokacija LIKE '$pojam'";
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
    }else {
        $broj_stranica = stranice_ispisa("rezervacija", $prikazi);

        $upit = "SELECT * FROM rezervacija r JOIN korisnik k ON r.korisnik_id = k.id_korisnik JOIN projekcija p ON r.projekcija_id = p.id_projekcija 
                  JOIN film f ON p.film_id = f.id_film JOIN lokacija l ON p.lokacija_id = l.id_lokacija";
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

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            switch ($red['status']){
                case 0:
                    $status = "Bez statusa";
                    break;
                case 1:
                    $status = "Potvrđena";
                    break;
                case 2:
                    $status = "Odbijena";
            }

            $polje = array(
                "id" => $red['id_rezervacija'],
                "korisnik" => $red['korisnicko_ime'],
                "status" => $status,
                "broj_rezervacija" => $red['broj_rezervacija'],
                "id_projekcija" => $red['id_projekcija'],
                "film" => $red["naziv_film"] . " (" . $red['godina'] . ") ",
                "vrijeme" => date("d.m.Y, H:i", $red['dostupan_do']),
                "lokacija" => $red['naziv_lokacija']
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