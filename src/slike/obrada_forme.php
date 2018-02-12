<?php
require_once '../klase/baza.php';
require_once '../dnevnik_rada/dnevnik_rada.php';

$dir = "uploads/";
$datoteka = $dir . basename($_FILES["slika"]["name"]);

if($_FILES['slika']['error'] !== UPLOAD_ERR_NO_FILE) {

    //promjena imena slike
    if (file_exists($datoteka)) {

        $tmp = explode(".", $_FILES["slika"]["name"]);

        $ime = round(microtime(true)) . '.' . end($tmp);

        if(!move_uploaded_file($_FILES["slika"]["tmp_name"], "uploads/" . $ime)){
            echo json_encode(array("poruka" => "Slika nije dodana. Pokušajte ponovo.."));
            exit();
        }

    } else {
        if (move_uploaded_file($_FILES["slika"]["tmp_name"], $datoteka)) {
            $ime = basename($_FILES["slika"]["name"]);

        } else {
            echo json_encode(array("poruka" => "Slika nije dodana. Pokušajte ponovo."));
            exit();
        }
    }
    $rezervacija = $_POST['id'];
    $oznake= $_POST['oznaka'];

    $baza = new baza();

    $upit = "INSERT INTO slika VALUES (default, '$ime', $rezervacija)";
    $baza->update($upit);

    $upit = "SELECT id_slika FROM slika WHERE naziv_slika = '$ime'";
    $rez = $baza->selectdb($upit);
    list($id_slika) = $rez->fetch_array();
    dnevnik("Upload slike",1,0);

    foreach ($oznake as $oznaka){
        $upit = "SELECT id_tag FROM tag WHERE naziv_tag = '$oznaka'";
        $rezultat = $baza->selectdb($upit);

        if($rezultat->num_rows === 0){

            $upit = "INSERT INTO tag VALUES (default, '$oznaka')";
            $baza->update($upit);

            $upit = "SELECT id_tag FROM tag WHERE naziv_tag = '$oznaka'";
            $rez = $baza->selectdb($upit);
            list($id_tag) = $rez->fetch_array();

        }else{
            list($id_tag) = $rezultat->fetch_array();
        }

        $upit = "INSERT INTO tagslika VALUES ($id_slika, $id_tag)";
        $baza->update($upit);
        dnevnik($upit, 2,0);
    }

    echo json_encode(array("poruka" => "Slika uspješno dodana."));
}else{
    echo json_encode(array("poruka" => "Pogreška prilikom dodavanja slike. Pokušajte ponovo."));
}