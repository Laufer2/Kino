<?php

if(filter_input(INPUT_SERVER,'REQUEST_METHOD') == 'POST'){

    session_start();
    setcookie(session_name(), '', -3600);
    session_unset();
    session_destroy();
    $_SESSION = array();

}