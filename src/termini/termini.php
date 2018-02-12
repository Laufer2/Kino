<?php

require_once '../klase/baza.php';
require_once '../klase/korisnik.php';
require_once '../statistike/evidencija.php';
require_once '../dnevnik_rada/dnevnik_rada.php';


if(!isset($_SESSION))
{
    session_start();
}

$korisnik = $_SESSION['kino']->getIdKorisnik();
$admin = $_SESSION['kino']->getTipId();

$baza = new baza();

if(isset($_POST['selectmenu'])) {

    $json['lokacije'] = array();

    $upit = "SELECT * FROM lokacija l JOIN moderatorlokacije m ON l.id_lokacija = m.lokacija_id WHERE korisnik_id = $korisnik";

    if($admin == 1){
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

    $json['filmovi'] = array();
    dnevnik("Termini", 3, 0);

    $upit = "SELECT * FROM film";
    dnevnik($upit, 2, 0);
    stranica(5);
    $rezultat = $baza->selectdb($upit);

    while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

        $polje = array(
            "id" => $red['id_film'],
            "naziv" => $red['naziv_film'] . " (" . $red['godina'] . ")"
        );
        array_push($json['filmovi'], $polje);
    }

    echo json_encode($json);
}else{

    //termin
    $film = filter_input(INPUT_POST,'Film');
    $lokacija = filter_input(INPUT_POST,'Lokacije');
    $mjesta = filter_input(INPUT_POST,'mjesta');

    $datum1 = filter_input(INPUT_POST,'datum1');
    $sati1 = filter_input(INPUT_POST,'sati1');
    $minute1 = filter_input(INPUT_POST,'minute1');
    $datum2 = filter_input(INPUT_POST,'datum2');
    $sati2 = filter_input(INPUT_POST,'sati2');
    $minute2 = filter_input(INPUT_POST,'minute2');

    $dat1 = strtotime($datum1);
    $dostupan_od = $dat1 + ($sati1*60*60) + ($minute1 * 60);

    $dat2 = strtotime($datum2);
    $pocetak = $dat2 + ($sati2*60*60) + ($minute2 * 60);

    $upit = "INSERT INTO projekcija VALUES (default, $lokacija, $film, $mjesta, $dostupan_od, $pocetak)";
    upit(3);
    $baza->update($upit);

    echo json_encode(array("poruka"=>"Novi termin je kreiran"));


}