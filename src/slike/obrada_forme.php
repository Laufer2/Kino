<?php

$dir = "uploads/";
$datoteka = $dir . basename($_FILES["slika"]["name"]);

if($_FILES['slika']['error'] !== UPLOAD_ERR_NO_FILE) {

    if (file_exists($datoteka)) {

        $tmp = explode(".", $_FILES["slika"]["name"]);

        $novo_ime = round(microtime(true)) . '.' . end($tmp);

        if(move_uploaded_file($_FILES["slika"]["tmp_name"], "uploads/" . $novo_ime)){
            return $novo_ime;
        }else{
            return false;
        }

    } else {
        if (move_uploaded_file($_FILES["slika"]["tmp_name"], $datoteka)) {
            $ime = basename($_FILES["slika"]["name"]);

            return $ime;

        } else {
            return false;
        }
    }
}else{
    return false;
}