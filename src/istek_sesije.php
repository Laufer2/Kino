<?php

require_once 'klase/datoteka.php';
require_once 'klase/korisnik.php';
require_once 'serverske_poruke.php';

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

        $uri = $_SERVER["REQUEST_URI"];
        $pos = strrpos($uri, "/");
        $dir = $_SERVER["HTTP_HOST"] . substr($uri, 0, $pos - 3);
        $url = "http://" . $dir . "index.php";

        posalji_poruku("",$url);
        exit();
    }else{
        posalji_poruku("");
        exit();
    }
}
echo json_encode(array("redirect" => 0));

