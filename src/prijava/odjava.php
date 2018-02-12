<?php
require_once '../dnevnik_rada/dnevnik_rada.php';
require_once '../serverske_poruke.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD') == 'POST'){

    dnevnik("Odjava",1, 0);
    if(!isset($_SESSION)){
        session_start();
    }
    setcookie(session_name(), '', -3600);
    session_unset();
    session_destroy();
    $_SESSION = array();

    $uri = $_SERVER["REQUEST_URI"];
    $pos = strrpos($uri, "/");
    $dir = $_SERVER["HTTP_HOST"] . substr($uri, 0, $pos - 11);
    $url = "http://" . $dir . "index.php";

    posalji_poruku("",$url);

}