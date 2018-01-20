<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';
require_once '../serverske_poruke.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'GET') {

    if(!isset($_GET['tablica'])){
        posalji_poruku("Tablica nije definirana.");
        exit();
    }
    $tablica = filter_input(INPUT_GET, 'tablica');
    $pojam = filter_input(INPUT_GET, 'pojam');

    $sort = filter_input(INPUT_GET,'sort');

    $aktivna_stranica = filter_input(INPUT_GET,'stranica');
    $id = filter_input(INPUT_GET, 'id');
    $akcija = filter_input(INPUT_GET, 'akcija');
    $naziv = filter_input(INPUT_GET, 'naziv');

    $baza = new baza();
    $dat = new datoteka();

    $db_stupac = "naziv_" . $tablica;
    $db_id = "id_" . $tablica;

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $json = array();
    $json['podaci']=array();

    switch ($akcija){
        case 1: //brisanje (delete)
            $upit = "DELETE FROM $tablica WHERE $db_id = $id;";
            $rezultat = $baza->update($upit);

            break;
        case 2: // kreiranje novog (insert)
            $upit = "INSERT INTO $tablica VALUES(default, '$naziv')";
            $rezultat = $baza->update($upit);

            break;
        case 3: //dohvati jednog
            $upit = "SELECT * FROM $tablica WHERE $db_id = $id";
            $rezultat = $baza->update($upit);
            list($id, $naziv) = $rezultat->fetch_array();
            $polje = array("id" => $id, "naziv" => $naziv);
            echo json_encode($polje);
            exit();

        case 4: // ažuriranje (update)
            $upit = "UPDATE $tablica SET $db_stupac = '$naziv' WHERE $db_id = $id;";
            $rezultat = $baza->update($upit);
            break;

    }

    $broj_stranica = stranice_ispisa($tablica, $prikazi);

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if(!$sort){ //bez sorta

        $upit = "SELECT * FROM $tablica";
        if($akcija == 5 && $pojam != ""){ //search
            $upit .= " WHERE $db_stupac = '$pojam%'";
        }
        if($broj_stranica){ // paginacija u searchu neće raditi jer treba izbrojati redove u search upitu
            $upit .= " LIMIT $prikazi OFFSET $offset";
        }
    }else{
        $upit = "SELECT * FROM $tablica ORDER BY $db_stupac";

        if(!$broj_stranica){
            $upit .= " LIMIT $prikazi OFFSET $offset";
        }
    }

    $rezultat = $baza->selectdb($upit);

    while($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

        $polje = array(
            "id" => $red[$db_id],
            "naziv" => $red[$db_stupac]
        );
        array_push($json['podaci'], $polje);
    }

    $json['broj_stranica'] = $broj_stranica;
    $json['tablica'] = $tablica;

    echo json_encode($json);

}
