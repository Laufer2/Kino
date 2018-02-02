<?php

require_once 'klase/korisnik.php';
require_once 'klase/datoteka.php';
//require_once 'istek_sesije.php';

//echo istek_sesije();
//session_write_close();

function restrikcije($smarty){

    session_start();
    if (!isset($_SESSION['kino'])){
        $tip_korisnika = 4;
    }else{
        $tip_korisnika = $_SESSION['kino']->getTipId();
    }


    //print_r( $_SESSION['kino']);
/*
    $prijava = $_SESSION['kino']->getPrijavljenOd();


    $dat = new datoteka();
    $trajanje_sesije = $dat->dohvati('trajanje_sesije');
    $pomak = $dat->dohvati('pomak');
    $virtualno_vrijeme = time() + ($pomak * 60 * 60);
    $max_prijava = $prijava + ($trajanje_sesije * 60);

    echo date("d.m.Y, H:i:s", $_SESSION['kino']->getPrijavljenOd()) .
        "   VV: " . date("d.m.Y, H:i:s",$virtualno_vrijeme) .
            "   Max: " . date("d.m.Y, H:i:s",$max_prijava);*/

//koja navigacija će se ispisati
    switch ($tip_korisnika){
        case 4:
            $smarty->assign('Lurker', "1");
            break;
        case 3:
            $smarty->assign('Korisnik',"1");
            break;
        case 2:
            $smarty->assign('Moderator',"1");
            break;
        case 1:
            $smarty->assign('Admin',"1");
            break;
    }

    return $tip_korisnika;
}