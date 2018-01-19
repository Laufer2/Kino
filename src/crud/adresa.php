<?php

require_once '../klase/baza.php';
require_once '../stranice_ispisa.php';
require_once '../klase/datoteka.php';
require_once '../serverske_poruke.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');
    $sort = filter_input(INPUT_POST, 'sort');
    $aktivna_stranica = filter_input(INPUT_POST, 'stranica');
    $id = filter_input(INPUT_POST, 'id');
    $akcija = filter_input(INPUT_POST, 'akcija');
    $selectmenu = filter_input(INPUT_POST,'selectmenu');

    $baza = new baza();
    $dat = new datoteka();

    $poruka = 0;
    $json = array();
    $json['podaci'] = array();

    //novi zapis
    if($akcija < 3) {

        $lokacija = filter_input(INPUT_POST, 'lokacija');
        $ulica = filter_input(INPUT_POST, 'ulica');
        $broj = filter_input(INPUT_POST, 'broj');
        $postanski_broj = filter_input(INPUT_POST, 'postanski_broj');
        $grad = filter_input(INPUT_POST, 'grad');
        $drzava = filter_input(INPUT_POST, 'drzava');
    }

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
            //provjera da li postoji adresa za navedenu lokaciju
            $upit = "SELECT id_adresa FROM adresa WHERE lokacija_id = $lokacija";
            $rezultat = $baza->selectdb($upit);

            if($rezultat->num_rows){
                $poruka = 1;
                break;
            }

            $upit = "INSERT INTO adresa VALUES (default,'$ulica', $broj, $lokacija, $grad, $drzava, $postanski_broj)";
            $rezultat = $baza->update($upit);
            break;

        case 2:// ažuriranje
            $upit = "UPDATE adresa SET lokacija_id = $lokacija, ulica = '$ulica', broj = $broj, grad_id = $grad, 
                      drzava_id = $drzava WHERE id_adresa = $id;";
            $rezultat = $baza->update($upit);
            break;

        case 3: // brisanje
            $upit = "DELETE FROM adresa WHERE id_adresa = $id";
            $rezultat = $baza->update($upit);
            break;

        case 4: //dohvati jednoga za ažuriranje
            $upit = "SELECT * FROM adresa WHERE id_adresa = $id";
            $rezultat = $baza->selectdb($upit);

            list($id_adresa, $ulica, $broj, $lokacija, $grad, $drzava, $postanski_broj) = $rezultat->fetch_array();
            $polje = array(
                "id" => $id,
                "ulica" => $ulica,
                "broj" => $broj,
                "grad" => $grad,
                "drzava" => $drzava,
                "lokacija" => $lokacija,
                "postanski_broj" => $postanski_broj
                );
            array_push($json['podaci'],$polje);
            echo json_encode($json);
            exit();
        case 5:

            break;
    }

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    if ($akcija == 5 && $pojam != ""){ // search
        $a = "%";
        $pojam = $a . $pojam . $a;
        $upit = "SELECT * FROM adresa a JOIN lokacija l ON a.lokacija_id = l.id_lokacija JOIN grad g ON a.grad_id = g.id_grad
                      JOIN drzava d ON a.drzava_id = d.id_drzava WHERE d.naziv_drzava LIKE '$pojam' OR g.naziv_grad LIKE '$pojam' OR 
                      l.naziv_lokacija LIKE '$pojam' OR a.ulica LIKE '$pojam'";
    }else {
        $upit = "SELECT * FROM adresa a JOIN lokacija l ON a.lokacija_id = l.id_lokacija 
              JOIN grad g ON a.grad_id = g.id_grad JOIN drzava d ON a.drzava_id = d.id_drzava";
    }

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "id" => $red['id_adresa'],
                "lokacija" => $red['naziv_lokacija'],
                "ulica" => $red['ulica'],
                "broj" => $red['broj'],
                "postanski_broj" => $red['postanski_broj'],
                "grad" => $red['naziv_grad'],
                "drzava" => $red['naziv_drzava']
            );

            array_push($json['podaci'],$polje);
        }

        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);

    }else{

        $poruka = 1;

        $json['poruka'] = array('poruka'=>$poruka);

        echo json_encode($json);

    }
}