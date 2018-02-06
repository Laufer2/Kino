<?php

require_once 'klase/datoteka.php';
require_once 'klase/korisnik.php';

function istek_sesije(){

    $dat = new datoteka();
    $trajanje_sesije = $dat->dohvati('trajanje_sesije');
    $pomak = $dat->dohvati('pomak');
    $virtualno_vrijeme = time() + ($pomak * 60 * 60);
    if(!isset($_SESSION)) {
        session_start();
    }
    if(isset($_SESSION['kino']) && $trajanje_sesije > 0){

        $prijava = $_SESSION['kino']->getPrijavljenOd();

        $max_prijava = $prijava + ($trajanje_sesije * 60);

        if($max_prijava < $virtualno_vrijeme){

            setcookie(session_name(), '', -3600);
            session_unset();
            session_destroy();
            $_SESSION = array();
            session_write_close();
            return true;
        }
    }
    session_write_close();
    return false;
}