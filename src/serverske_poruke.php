<?php

function posalji_poruku($sadrzaj, $redirect=0){
    $polje = array("poruka" => $sadrzaj, "redirect" => $redirect);
    echo json_encode($polje);
}

function posalji_mail($primatelj, $naslov, $poruka, $podaci=''){
    $header = "MIME-Version: 1.0" . "\r\n";
    $header .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $header .= "From: webmaster@kino.org" . "\r\n";

    if(mail($primatelj,$naslov,$poruka,$header)){
        return true;
    }else{
        return false;
    }
}