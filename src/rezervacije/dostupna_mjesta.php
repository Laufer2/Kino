<?php

require_once '../klase/baza.php';

$baza = new baza();
$json = array();

$id_projekcija = filter_input(INPUT_POST,'id');

$upit = "SELECT max_gledatelja FROM projekcija p JOIN film f ON p.film_id = f.id_film WHERE  p.id_projekcija = $id_projekcija";

$rezultat = $baza->selectdb($upit);

list($max) = $rezultat->fetch_array();

$upit = "SELECT COUNT(*)as broj FROM rezervacija WHERE projekcija_id = $id_projekcija AND status = 1";
$rezultat = $baza->selectdb($upit);
list($broj) = $rezultat->fetch_array();

if($broj >= $max){
    $json['poruka'] = "Sva mjesta su popunjena.";
}

$json['mjesta'] = $max - $broj;

echo json_encode($json);