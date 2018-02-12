<?php
require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';
require_once '../dnevnik_rada/dnevnik_rada.php';
require_once '../statistike/evidencija.php';

$baza = new baza();

$json = array();

if(isset($_POST['izbornik'])) { // padajući izbornik lokacija

    $tablica = filter_input(INPUT_POST, 'tablica');

    $json['lokacije'] = array();

    $upit = "SELECT * FROM $tablica";

    $rezultat = $baza->selectdb($upit);

    while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

        $polje = array(
            "id" => $red['id_lokacija'],
            "naziv" => $red['naziv_lokacija']
        );
        array_push($json['lokacije'], $polje);
    }

    echo json_encode($json);

}else{

    $id = filter_input(INPUT_POST,'id');
    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');

    $json['projekcije'] = array();
    $dat = new datoteka();
    $poruka = 0;

    $pomak = $dat->dohvati('pomak');
    $virtualno_vrijeme = time() + ($pomak *60*60);

    $prikazi = $dat->dohvati('prikazi_po_stranici');
    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if (isset($_POST['akcija']) && $pojam != "") { // search

        $upit = "SELECT * FROM projekcija p JOIN film f ON p.film_id = f.id_film WHERE NOT p.dostupan_do < $virtualno_vrijeme AND p.lokacija_id = $id
                  AND f.naziv_film LIKE '%$pojam%'";

    }else{
        $broj_stranica = stranice_ispisa("projekcija", $prikazi);

        $upit = "SELECT * FROM projekcija p JOIN film f ON p.film_id = f.id_film WHERE NOT p.dostupan_do < $virtualno_vrijeme AND p.lokacija_id = $id";
        dnevnik($upit, 2, 0);
        stranica(1);
    }

    if(isset($tip_sorta) && $tip_sorta != "" ) {
        $upit .= " ORDER by $stupac $tip_sorta";
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

    if($rezultat = $baza->selectdb($upit)) {

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red['id_projekcija'],
                "naziv" => $red['naziv_film'],
                "trajanje" => $red['trajanje'],
                "pocetak" => date("d.m.Y, H:i", $red['dostupan_do'])
            );

            $id_filma = $red['id_film'];
            $polje['zanr'] = array();
            $polje['redatelj'] = array();

            $up = "SELECT z.naziv_zanr FROM zanr z JOIN zanrfilma z2 ON z.id_zanr = z2.zanr_id  
                    WHERE z2.film_id = $id_filma";

            $rez = $baza->selectdb($up);
            while ($row = $rez->fetch_array(MYSQLI_ASSOC)) {

                array_push($polje['zanr'], $row['naziv_zanr']);

            }

            $up = "SELECT o.naziv_osoba FROM osoba o JOIN filmosoba f ON o.id_osoba = f.osoba_id JOIN tipuloga t ON f.uloga_id = t.id_tipuloga 
                     WHERE f.film_id = $id_filma AND t.naziv_tipuloga = 'Redatelj'";

            $rez = $baza->selectdb($up);
            while ($row = $rez->fetch_array(MYSQLI_ASSOC)) {

                array_push($polje['redatelj'], $row['naziv_osoba']);

            }

            array_push($json['projekcije'], $polje);
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