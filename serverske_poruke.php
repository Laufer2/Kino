<?php

function posalji_poruku($sadrzaj){
    $polje = array("poruka" => $sadrzaj);
    echo json_encode($polje);
}