<?php

require_once 'klase/korisnik.php';
require_once 'klase/datoteka.php';

function restrikcije($smarty){
    if(!isset($_SESSION)){
        session_start();
    }

    if (!isset($_SESSION['kino'])){
        $tip_korisnika = 4;
    }else{
        $tip_korisnika = $_SESSION['kino']->getTipId();
    }

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