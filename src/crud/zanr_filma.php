<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $idf = filter_input(INPUT_POST, 'idf');
    $idz = filter_input(INPUT_POST, 'idz');
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
        $zanr = filter_input(INPUT_POST, 'zanr'); //zanr_id

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
            $upit = "SELECT * FROM zanrfilma WHERE zanr_id = $zanr AND film_id = $film";
            $rezultat = $baza->selectdb($upit);

            if($rezultat->num_rows){
                $poruka = 1;
                break;
            }

            $upit = "INSERT INTO zanrfilma VALUES ($film, $zanr)";
            $rezultat = $baza->update($upit);

            break;

        case 3: // brisanje
            $upit = "DELETE FROM zanrfilma WHERE zanr_id = $idz AND film_id = $idf";
            $rezultat = $baza->update($upit);
            break;

    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM zanrfilma z JOIN film f ON z.film_id = f.id_film JOIN zanr z2 ON z.zanr_id = z2.id_zanr
                  WHERE f.naziv_film LIKE '$pojam' OR z2.naziv_zanr LIKE '$pojam'";
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
        $broj_stranica = stranice_ispisa("zanrfilma", $prikazi);

        $upit = "SELECT * FROM zanrfilma z JOIN film f ON z.film_id = f.id_film JOIN zanr z2 ON z.zanr_id = z2.id_zanr";
        if(isset($stupac) && $stupac != "" ) {
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
    $json['upit'] = $upit;

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "idz" => $red['zanr_id'],
                "idf" => $red['film_id'],
                "zanr" => $red['naziv_zanr'],
                "film" => $red['naziv_film'],

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