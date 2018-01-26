<?php

require_once '../klase/baza.php';
require_once '../klase/datoteka.php';
require_once '../klase/korisnik.php';

session_start();

$lokacija = filter_input(INPUT_POST,'lokacija');
$svidja = filter_input(INPUT_POST,'svidja');

//$korisnik = $_SESSION['kino']->getIdKorisnik();
$korisnik = 2;

$baza = new baza();

$upit = "SELECT svida_mi_se FROM lajkovi WHERE korisnik_id = $korisnik AND lokacija_id = $lokacija";

$rezultat = $baza->selectdb($upit);


if($rezultat->num_rows){

    list($svida_mi_se) = $rezultat->fetch_array();

    if($svida_mi_se == $svidja){
        $upit = "DELETE FROM lajkovi WHERE korisnik_id = $korisnik AND lokacija_id = $lokacija";
        $rez = $baza->update($upit);
    }else{
        $upit = "UPDATE lajkovi SET svida_mi_se = $svidja WHERE korisnik_id = $korisnik AND lokacija_id = $lokacija";
        $rez = $baza->update($upit);
    }

}else{

    $dat = new datoteka();
    $pomak = $dat->dohvati('pomak');
    $vrijeme = time() + ($pomak * 60 * 60);

    $upit = "INSERT INTO lajkovi VALUES ($korisnik, $lokacija, $svidja, $vrijeme)";
    $rez = $baza->update($upit);

}

    $u = "SELECT COUNT(*) as lajk FROM lajkovi WHERE lokacija_id=$lokacija AND svida_mi_se = 1";
    $rez = $baza->selectdb($u);
    list($lajk) = $rez->fetch_array();

    $u = "SELECT COUNT(*) as lajk FROM lajkovi WHERE lokacija_id=$lokacija AND svida_mi_se = 0";
    $rez = $baza->selectdb($u);
    list($nelajk) = $rez->fetch_array();

echo json_encode(array("lajk" => $lajk, "nelajk" => $nelajk));


