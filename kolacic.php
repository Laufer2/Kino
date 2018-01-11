<?php
require_once 'serverske_poruke.php';

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST'){

    if(filter_input(INPUT_COOKIE,'kino') !== null){
        posalji_poruku(filter_input(INPUT_COOKIE,'kino'));
    }else{
        posalji_poruku("");
    }
}