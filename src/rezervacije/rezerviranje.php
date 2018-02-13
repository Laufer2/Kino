<?php

require_once '../klase/baza.php';
require_once '../dnevnik_rada/dnevnik_rada.php';

if(!isset($_SESSION)){
    session_start();
}

$broj_rezervacija = filter_input(INPUT_POST,'broj_rezervacija');
$korisnik = $_SESSION['kino']->getIdKorisnik();
$projekcija = filter_input(INPUT_POST,'projekcija');

$json = array();
$baza = new baza();

$upit = "INSERT INTO rezervacija VALUES (default, $broj_rezervacija, default, $korisnik, $projekcija)";
dnevnik($upit, 2, 0);


if($rezultati = $baza->update($upit)){

    $json['poruka'] = "Poslan je zahtjev za ". $broj_rezervacija . " rezervacije. Primit ćete mail kad rezervacije budu obrađene.";

}else{

    $json['poruka'] = "Dogodila se greška. Pokušajte ponovo.";

}

echo json_encode($json);



