<?php

require_once '../klase/baza.php';
require_once '../klase/datoteka.php';

function dnevnik($zapis, $tip, $id_korisnik){

    $dat = new datoteka();
    $pomak = $dat->dohvati('pomak');

    $korisnik = isset($_SESSION["Kino"]) ? $_SESSION["Kino"]->getIdKorisnik() : $id_korisnik;
    $vrijeme = time()+($pomak * 60 * 60);
    $ip_adresa = $_SERVER["REMOTE_ADDR"];

    $baza = new baza();

    $upit = "INSERT INTO log VALUES (default, $korisnik,$vrijeme,'$ip_adresa')";

    $rez = $baza->update($upit);

    $upit = "SELECT id_log FROM log WHERE vrijeme = $vrijeme";
    $rez = $baza->selectdb($upit);
    list($id_log) = $rez->fetch_array();

    if($tip == 1){
        $upit = "INSERT INTO logradnja VALUES ($id_log, '$zapis')";
    }else{
        $upit = "INSERT INTO logbaza VALUES ($id_log, '$zapis')";
    }

    if($rezultat = $baza->update($upit)){
        return true;
    }else{
        return false;
    }
}