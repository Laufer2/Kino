<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $stupac = filter_input(INPUT_POST, 'stupac');
    $tip_sorta = filter_input(INPUT_POST,'tip_sorta');
    $aktivna_stranica = filter_input(INPUT_POST, 'aktivna_stranica');
    $idk = filter_input(INPUT_POST, 'idk');
    $idl = filter_input(INPUT_POST, 'idl');
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
        $korisnik = filter_input(INPUT_POST, 'korisnik');
        $svidjanje = filter_input(INPUT_POST,'svidjanje');
        $datum1 = filter_input(INPUT_POST,'datum1');
        $sati1 = filter_input(INPUT_POST,'sati1');
        $minute1 = filter_input(INPUT_POST,'minute1');

        $dat1 = strtotime($datum1);
        $vrijeme = $dat1 + ($sati1*60*60) + ($minute1 * 60);

    }

    // padajući meniji za vanjske ključeve
    if ($selectmenu){

        $tablice = $_POST['tablica'];

        foreach($tablice as $tablica) {

            $db_id = "id_" . $tablica;

            $upit = "SELECT * FROM $tablica";

            $rezultat = $baza->selectdb($upit);

            if($tablica == "korisnik"){
                $db_stupac = "korisnicko_ime";
            }else{
                $db_stupac = "naziv_" . $tablica;
            }

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
            $upit = "SELECT * FROM lajkovi WHERE lokacija_id = $lokacija AND korisnik_id = $korisnik";
            $rezultat = $baza->selectdb($upit);

            if($rezultat->num_rows){
                $poruka = "Taj zapis već postoji";
            }else{
                $upit = "INSERT INTO lajkovi VALUES ($korisnik, $lokacija, $svidjanje, $vrijeme)";
                $rezultat = $baza->update($upit);
            }
            $json['u']=$upit;
            break;

        case 2:// ažuriranje
            $upit = "UPDATE lajkovi SET svida_mi_se = $svidjanje, vrijeme=$vrijeme WHERE korisnik_id = $idk AND lokacija_id = $idl";
            $rezultat = $baza->update($upit);

            break;

        case 3: // brisanje
            $upit = "DELETE FROM lajkovi WHERE korisnik_id = $idk AND lokacija_id = $idl";
            $rezultat = $baza->selectdb($upit);
            break;

        case 4: // dohvati jednog za ažuriranje
            $upit = "SELECT * FROM lajkovi WHERE lokacija_id = $idl AND korisnik_id = $idk";
            $rezultat = $baza->selectdb($upit);
            list($korisnik, $lokacija, $svidjanje, $vrijeme) = $rezultat->fetch_array();

            $vrijeme = date("Y-m-d;H;i", $vrijeme);
            $split = explode(";",$vrijeme);
            $datum = $split[0];
            $sati = $split[1];
            $minute = $split[2];

            $polje = array(
                "korisnik" => $korisnik,
                "lokacija" => $lokacija,
                "svidjanje" => $svidjanje,
                "datum1" => $datum,
                "sati1" => $sati,
                "minute1" => $minute,
                "idl" => $lokacija,
                "idk" => $korisnik
            );
            array_push($json['podaci'],$polje);
            echo json_encode($json);
            exit();
    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM lajkovi l JOIN lokacija l2 ON l.lokacija_id = l2.id_lokacija JOIN korisnik k ON l.korisnik_id = k.id_korisnik
                  WHERE k.korisnicko_ime LIKE '$pojam' OR l2.naziv_lokacija LIKE '$pojam'";
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
        $broj_stranica = stranice_ispisa("lajkovi", $prikazi);

        $upit = "SELECT * FROM lajkovi l JOIN lokacija l2 ON l.lokacija_id = l2.id_lokacija JOIN korisnik k ON l.korisnik_id = k.id_korisnik";
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
                "idl" => $red['lokacija_id'],
                "idk" => $red['korisnik_id'],
                "lokacija" => $red['naziv_lokacija'],
                "korisnik" => $red['korisnicko_ime'],
                "svidjanje" => $red['svida_mi_se'] > 0 ? "Sviđa mi se" : "Ne sviđa mi se",
                "vrijeme" => date("j.m.Y, H:i", $red['vrijeme'])
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