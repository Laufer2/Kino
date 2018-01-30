<?php

require_once '../klase/baza.php';
require_once '../klase/datoteka.php';
require_once '../klase/korisnik.php';
session_start();

function dnevnik($zapis, $tip, $id_korisnik){

    $dat = new datoteka();
    $pomak = $dat->dohvati('pomak');

    $korisnik = isset($_SESSION["Kino"]) ? $_SESSION["Kino"]->getIdKorisnik() : $id_korisnik;
    $vrijeme = time()+($pomak * 60 * 60);
    $ip_adresa = $_SERVER["REMOTE_ADDR"];

    $uri = $_SERVER["REQUEST_URI"];
    $pos = strrpos($uri, "/");
    $skripta = substr($uri, $pos+1);

    $baza = new baza();

    $upit = "INSERT INTO log VALUES (default, $korisnik,$vrijeme,'$ip_adresa', '$skripta', $tip, '$zapis')";

    if($rezultat = $baza->update($upit)){
        return true;
    }else{
        return false;
    }
}