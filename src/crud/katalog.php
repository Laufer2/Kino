<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'GET') {

    if(!isset($_GET['tablica'])){
        echo json_encode("Tablica nije poslana");
    }

    $tablica = filter_input(INPUT_GET, 'tablica');
    $pojam = filter_input(INPUT_GET, 'pojam');
    $stupac = filter_input(INPUT_GET, 'stupac');
    $tip_sorta = filter_input(INPUT_GET,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_GET,'aktivna_stranica');
    $id = filter_input(INPUT_GET, 'id');
    $akcija = filter_input(INPUT_GET, 'akcija');
    $naziv = filter_input(INPUT_GET, 'naziv');

    $baza = new baza();
    $dat = new datoteka();

    $poruka = $broj_stranica = 0;
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
            //provjera da li postoji adresa za navedenu lokaciju
            $upit = "SELECT * FROM $tablica WHERE $db_stupac = '$naziv'";
            $rezultat = $baza->selectdb($upit);

            if($rezultat->num_rows){
                $poruka = 1;
                break;
            }
            $upit = "INSERT INTO $tablica VALUES(default, '$naziv')";

            $rezultat = $baza->update($upit);
            $json['upit2']=$upit;

            break;
        case 3: //dohvati jednog
            $upit = "SELECT * FROM $tablica WHERE $db_id = $id";
            $rezultat = $baza->update($upit);
            list($id, $naziv) = $rezultat->fetch_array();
            $polje = array("id" => $id, "naziv" => $naziv);
            echo json_encode($polje);
            exit();

        case 4: // ažuriranje (update)
            $upit = "SELECT * FROM $tablica WHERE $db_stupac = '$naziv'";

            $rezultat = $baza->selectdb($upit);

            list($id_tablice) = $rezultat->fetch_array();
            if(!$rezultat->num_rows && $id_tablice != $id){

                $upit = "UPDATE $tablica SET $db_stupac = '$naziv' WHERE $db_id = $id";
                dnevnik($upit, 2, 0);
                $rezultat = $baza->update($upit);

                break;
            }else{
                $poruka = 1;
            }

    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if($akcija == 5 && $pojam != ""){ //search
        $upit = "SELECT * FROM $tablica WHERE $db_stupac LIKE '%$pojam%'";
        if(isset($tip_sorta) && $tip_sorta != "" ) { // sort
            $upit .= " ORDER BY $stupac $tip_sorta";
            $json['tip_sorta'] = $tip_sorta;
            $json['stupac'] = $stupac;
        }else{
            $json['tip_sorta'] = "";
            $json['stupac'] = "";
        }

        $rezultat = $baza->selectdb($upit);
        $redovi = $rezultat->num_rows;

        if(!$redovi){
            $poruka = 1;
        }

        if ($rezultat > $prikazi){
            $broj_stranica = ceil($redovi/$prikazi);
        }else{
            $broj_stranica = 0;
        }

        //paginacija
        if($broj_stranica){
            $upit .= " LIMIT $prikazi OFFSET $offset";
        }
    }else{ // prikaz bez searcha
        $broj_stranica = stranice_ispisa($tablica, $prikazi);

        $upit = "SELECT * FROM $tablica";
        if(isset($tip_sorta) && $tip_sorta != "" ) { // sortirani prikaz
            $upit .= " ORDER BY $db_stupac $tip_sorta";
            $json['tip_sorta'] = $tip_sorta;
            $json['stupac'] = $db_stupac;
        }else{
            $json['tip_sorta'] = "";
            $json['stupac'] = "";
        }

        if($broj_stranica){
            $upit .= " LIMIT $prikazi OFFSET $offset";
        }
    }

    if($rezultat = $baza->selectdb($upit)) {

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red[$db_id],
                "naziv" => $red[$db_stupac]
            );
            array_push($json['podaci'], $polje);
        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['tablica'] = $tablica;
        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);

    }else{
        $poruka = 1;

        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);
    }
}
