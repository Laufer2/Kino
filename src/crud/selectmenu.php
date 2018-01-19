<?php

require_once '../klase/baza.php';

$tablice = $_POST['tablica'];

$baza = new baza();

$json = array();

foreach($tablice as $tablica) {

    $db_id = "id_" . $tablica;

    $upit = "SELECT * FROM $tablica";

    $rezultat = $baza->selectdb($upit);

    $db_stupac = "naziv_" . $tablica;

    $json[$tablica] = array();

    while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

        $polje = array(
            "id" => $red[$db_id],
            "naziv" => $red[$db_stupac]
        );

        array_push($json[$tablica], $polje);
    }
}

echo json_encode($json);