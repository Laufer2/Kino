<?php

require_once '../klase/baza.php';
require_once '../klase/korisnik.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'POST') {

    $pojam = filter_input(INPUT_POST, 'pojam');

    if(!isset($_SESSION)){
        session_start();
    }

    $baza = new baza();
    $korisnik = $_SESSION['kino']->getIdKorisnik();

    if((isset($_POST['sve']) && $_POST['sve'] == 1) || (isset($_POST['pojam']) && $_POST['pojam'] == "")){
        $upit = "SELECT slika.naziv_slika FROM slika JOIN rezervacija r ON slika.rezervacija_id = r.id_rezervacija 
              JOIN tagslika t ON slika.id_slika = t.slika_id JOIN tag t2 ON t.tag_id = t2.id_tag
              WHERE r.korisnik_id = $korisnik GROUP BY slika.naziv_slika";
    }else{
        $upit = "SELECT slika.naziv_slika FROM slika JOIN rezervacija r ON slika.rezervacija_id = r.id_rezervacija 
              JOIN tagslika t ON slika.id_slika = t.slika_id JOIN tag t2 ON t.tag_id = t2.id_tag
              WHERE r.korisnik_id = $korisnik AND t2.naziv_tag = '$pojam' GROUP BY slika.naziv_slika";
    }

    $rezultat = $baza->selectdb($upit);

    $dir = "src/slike/uploads/";
    $json = array();
    $json['podaci'] = array();

    if($rezultat->num_rows){
        while($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "href" => $dir . $red['naziv_slika']
            );

            array_push($json['podaci'], $polje);
        }

        echo json_encode($json);
    }else{

        echo json_encode(array("poruka" => "Nema slika."));

    }


}