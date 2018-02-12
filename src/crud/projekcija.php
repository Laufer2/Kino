<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $id = filter_input(INPUT_POST, 'id');
    $akcija = filter_input(INPUT_POST, 'akcija');
    $selectmenu = filter_input(INPUT_POST,'selectmenu');

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    //novi zapis
    if($akcija < 3) {

        $lokacija = filter_input(INPUT_POST, 'lokacija');
        $film = filter_input(INPUT_POST, 'film');
        $max_gledatelja = filter_input(INPUT_POST, 'max_gledatelja');
        $datum1 = filter_input(INPUT_POST,'datum1');
        $sati1 = filter_input(INPUT_POST,'sati1');
        $minute1 = filter_input(INPUT_POST,'minute1');
        $datum2 = filter_input(INPUT_POST,'datum2');
        $sati2 = filter_input(INPUT_POST,'sati2');
        $minute2 = filter_input(INPUT_POST,'minute2');

        $dat1 = strtotime($datum1);
        $dostupan_od = $dat1 + ($sati1*60*60) + ($minute1 * 60);

        $dat2 = strtotime($datum2);
        $dostupan_do = $dat2 + ($sati2*60*60) + ($minute2 * 60);
    }

    // padajući meniji za vanjske ključeve
    if ($selectmenu){

        $tablice = $_POST['tablica'];

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
    }

    switch ($akcija){
        case 1://kreiranje

            $upit = "INSERT INTO projekcija VALUES (default, $lokacija, $film, $max_gledatelja, $dostupan_od, $dostupan_do)";
            $rezultat = $baza->update($upit);

            break;

        case 2:// ažuriranje

            $upit = "UPDATE projekcija SET lokacija_id = $lokacija, film_id = $film, max_gledatelja = $max_gledatelja, dostupan_od = $dostupan_od,  
                     dostupan_do = $dostupan_do WHERE id_projekcija = $id";
            $rezultat = $baza->update($upit);
            break;

        case 3: // brisanje
            $upit = "DELETE FROM projekcija WHERE id_projekcija = $id";
            $rezultat = $baza->update($upit);
            break;

        case 4: //dohvati jednoga za ažuriranje
            $upit = "SELECT * FROM projekcija WHERE id_projekcija = $id";
            $rezultat = $baza->selectdb($upit);

            list($id_projekcija, $lokacija, $film, $max_gledatelja, $dostupan_od, $dostupan_do) = $rezultat->fetch_array();

            $vrijeme = date("Y-m-d;H;i", $dostupan_od);
            $split = explode(";",$vrijeme);
            $datum = $split[0];
            $sati = $split[1];
            $minute = $split[2];

            $vrijeme4 = date("Y-m-d;H;i", $dostupan_do);
            $split4 = explode(";",$vrijeme4);
            $datum4 = $split4[0];
            $sati4 = $split4[1];
            $minute4 = $split4[2];

            $polje = array(
                "id" => $id,
                "lokacija" => $lokacija,
                "film" => $film,
                "max_gledatelja" => $max_gledatelja,
                "datum1" => $datum,
                "sati1" => $sati,
                "minute1" => $minute,
                "datum2" => $datum4,
                "sati2" => $sati4,
                "minute2" => $minute4
            );

            array_push($json['podaci'],$polje);
            echo json_encode($json);
            exit();
    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM projekcija p JOIN film f ON p.film_id = f.id_film JOIN lokacija l ON p.lokacija_id = l.id_lokacija 
                  WHERE l.naziv_lokacija LIKE '$pojam' OR f.naziv_film LIKE '$pojam'";
        if(isset($tip_sorta) && $tip_sorta != "" ) {
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
    }else {
        $broj_stranica = stranice_ispisa("projekcija", $prikazi);

        $upit = "SELECT * FROM projekcija p JOIN film f ON p.film_id = f.id_film JOIN lokacija l ON p.lokacija_id = l.id_lokacija";
        if(isset($tip_sorta) && $tip_sorta != "" ) {
            $upit .= " ORDER BY $stupac $tip_sorta";
            $json['tip_sorta'] = $tip_sorta;
            $json['stupac'] = $stupac;

        }else{
            $json['tip_sorta'] = "";
            $json['stupac'] = "";
        }

        if($broj_stranica){
            $upit .= " LIMIT $prikazi OFFSET $offset";
        }
    }

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "id" => $red['id_projekcija'],
                "lokacija" => $red['naziv_lokacija'],
                "film" => $red['naziv_film'],
                "max_gledatelja" => $red['max_gledatelja'],
                "dostupan_od" => date("d.m.Y, H:i", $red['dostupan_od']),
                "dostupan_do" => date("d.m.Y, H:i", $red['dostupan_do'])
            );

            array_push($json['podaci'],$polje);
        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['poruka'] = array('poruka'=>$poruka);

    }else{

        $poruka = 1;

        $json['poruka'] = array('poruka'=>$poruka);
    }

    echo json_encode($json);
}