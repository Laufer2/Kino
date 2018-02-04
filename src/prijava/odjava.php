<?php
require_once '../dnevnik_rada/dnevnik_rada.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD') == 'POST'){

    dnevnik("Odjava",1, 0);
    if(!isset($_SESSION)){
        session_start();
    }
    setcookie(session_name(), '', -3600);
    session_unset();
    session_destroy();
    $_SESSION = array();

}