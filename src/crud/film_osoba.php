<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';
require_once '../dnevnik_rada/dnevnik_rada.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $idf = filter_input(INPUT_POST, 'idf');
    $ido = filter_input(INPUT_POST, 'ido');
    $idu = filter_input(INPUT_POST, 'idu');
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

        $film = filter_input(INPUT_POST, 'film'); // film_id
        $osoba = filter_input(INPUT_POST, 'osoba'); //osoba_id
        $uloga = filter_input(INPUT_POST, 'uloga'); //osoba_id

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
            $upit = "SELECT * FROM filmosoba WHERE osoba_id = $osoba AND film_id = $film AND uloga_id = $uloga";
            dnevnik($upit, 2, 0);
            $rezultat = $baza->selectdb($upit);

            if($rezultat->num_rows){
                $poruka = 1;
                break;
            }

            $upit = "INSERT INTO filmosoba VALUES ($film, $osoba, $uloga)";
            dnevnik($upit, 2, 0);
            $rezultat = $baza->update($upit);

            break;

        case 3: // brisanje
            $upit = "DELETE FROM filmosoba WHERE osoba_id = $ido AND film_id = $idf AND uloga_id = $idu";
            dnevnik($upit, 2, 0);
            $rezultat = $baza->update($upit);
            break;

    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM filmosoba f JOIN film f2 ON f.film_id = f2.id_film JOIN osoba o ON f.osoba_id = o.id_osoba 
                  JOIN tipuloga t ON f.uloga_id = t.id_tipuloga
                  WHERE f2.naziv_film LIKE '$pojam' OR o.naziv_osoba LIKE '$pojam' OR t.naziv_tipuloga LIKE '$pojam' ";
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
        $broj_stranica = stranice_ispisa("filmosoba", $prikazi);

        $upit = "SELECT * FROM filmosoba f JOIN film f2 ON f.film_id = f2.id_film JOIN osoba o ON f.osoba_id = o.id_osoba 
                  JOIN tipuloga t ON f.uloga_id = t.id_tipuloga";
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
                "ido" => $red['osoba_id'],
                "idf" => $red['film_id'],
                "idu" => $red['uloga_id'],
                "osoba" => $red['naziv_osoba'],
                "film" => $red['naziv_film'],
                "uloga" => $red['naziv_tipuloga'],

            );

            array_push($json['podaci'],$polje);
        }

        $json['aktivna_stranica'] = intval($aktivna_stranica);
        $json['broj_stranica'] = $broj_stranica;
        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);

    }else{

        $poruka = 1;

        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);

    }
}