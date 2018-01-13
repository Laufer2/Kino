<?php

require_once '../klase/baza.php';

function dnevnik_zapis($upit){

    $korisnik = $_SESSION['kino']->getIdKorisnik;
    $vrijeme = time(); // dodati pomak ili ne
    $tip_radnje = "";
    $ip_adresa = $_SERVER["REMOTE_ADDR"];

    $u = "INSERT INTO korisnik(korisnik_id, vrijeme, tip_zapisa, upit, ip_adresa) VALUES ($korisnik,$vrijeme,$tip_radnje,$upit,$ip_adresa)";

    $baza = new baza();

    if($rezultat = $baza->update($u)){
        return true;
    }else{
        return false;
    }

}