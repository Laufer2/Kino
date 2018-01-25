<?php

require_once '../klase/baza.php';

$baza = new baza();

$json = array();


if(!isset($_POST['id'])) { // padajući izbornik lokacija

    $tablica = filter_input(INPUT_POST, 'tablica');

    $json['lokacije'] = array();

    $upit = "SELECT * FROM $tablica";

    $rezultat = $baza->selectdb($upit);

    while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

        $polje = array(
            "id" => $red['id_lokacija'],
            "naziv" => $red['naziv_lokacija']
        );
        array_push($json['lokacije'], $polje);

    }

    echo json_encode($json);

}else{ // tri najranije projekcije na odabranoj lokaciji

    $id = filter_input(INPUT_POST,'id');

    $json['projekcije'] = array();


    $upit = "SELECT * FROM projekcija p JOIN film f ON p.film_id = f.id_film WHERE p.dostupan_do > UNIX_TIMESTAMP() AND p.lokacija_id = $id  
              ORDER BY p.dostupan_do ASC LIMIT 3";

    $rezultat = $baza->selectdb($upit);

    while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

        $polje = array(
            "id" => $red['id_projekcija'],
            "naziv" => $red['naziv_film'],
            "trajanje" => $red['trajanje'],
            "pocetak" => date("F j, Y, H:i", $red['dostupan_do'])
        );

        $id_filma = $red['id_film'];
        $polje['zanr']=array();
        $polje['redatelj']=array();

        $up = "SELECT z.naziv_zanr FROM zanr z JOIN zanrfilma z2 ON z.id_zanr = z2.zanr_id  
                WHERE z2.film_id = $id_filma";

        $rez = $baza->selectdb($up);
        while($row = $rez->fetch_array(MYSQLI_ASSOC)){

             array_push($polje['zanr'],$row['naziv_zanr']);
             //$json['zanr'] = $row['zanr'];

        }

        $up = "SELECT o.naziv_osoba FROM osoba o JOIN filmosoba f ON o.id_osoba = f.osoba_id JOIN tipuloga t ON f.uloga_id = t.id_tipuloga 
                 WHERE f.film_id = $id_filma AND t.naziv_tipuloga = 'Redatelj'";

        $rez = $baza->selectdb($up);
        while($row = $rez->fetch_array(MYSQLI_ASSOC)){

            array_push($polje['redatelj'],$row['naziv_osoba']);

        }

        array_push($json['projekcije'], $polje);
    }

    echo json_encode($json);

}