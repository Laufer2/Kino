<?php
require_once '../klase/baza.php';
require_once '../klase/datoteka.php';

function stranica($id){

    $baza = new baza();
    $upit = "SELECT * FROM stranica WHERE id_stranica = $id";
    $rez = $baza->selectdb($upit);
    if($rez->num_rows){
        upis("korisnikstranica",$id);
    }
}

function upit($id){

    $baza = new baza();
    $upit = "SELECT * FROM upit WHERE id_upit = $id";
    $rez = $baza->selectdb($upit);
    if($rez->num_rows){
        upis("korisnikupit",$id);
    }
}

function upis($tablica, $id){

    if(!isset($_SESSION['kino'])){
        session_start();
    }

    $dat = new datoteka();
    $baza = new baza();

    $pomak = $dat->dohvati('pomak');
    $vrijeme = time() + ($pomak * 60 * 60);

    $korisnik = $_SESSION['kino']->getIdKorisnik();
    session_write_close();

    $upit = "INSERT INTO $tablica VALUES ($korisnik, $id, $vrijeme)";
    $baza->update($upit);

}