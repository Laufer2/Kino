<?php

require_once '../klase/baza.php';
require_once '../klase/korisnik.php';

$baza = new baza();

if(isset($_POST['selectmenu'])){
    $tablica = filter_input(INPUT_POST, 'tablica');

    $json['zanr'] = array();

    $upit = "SELECT * FROM zanr";

    $rezultat = $baza->selectdb($upit);

    while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

        $polje = array(
            "id" => $red['id_zanr'],
            "naziv" => $red['naziv_zanr']
        );
        array_push($json['zanr'], $polje);

    }

    echo json_encode($json);
}else{

    $film = filter_input(INPUT_POST,'film');
    $godina = filter_input(INPUT_POST,'godina');
    $trajanje = filter_input(INPUT_POST,'trajanje');
    $sadrzaj = filter_input(INPUT_POST,'sadrzaj');

    $redatelji = $_POST['redatelj'];
    $glumci = $_POST['glumac'];
    $scenaristi = $_POST['scenarist'];
    $zanrovi = $_POST['zanr'];

    dnevnik("Filmovi", 3, 0);

    // film s istim nazivom?
    $upit = "SELECT * FROM film WHERE naziv_film = '$film' AND godina = $godina";
    $rezultat = $baza->selectdb($upit);

    if($rezultat->num_rows){

        echo json_encode(array("poruka"=>"Taj film već postoji."));
        exit();
    }else{

        $upit = "INSERT INTO film VALUES (default, '$film', '$trajanje','$sadrzaj','$godina')";
        $rezultat = $baza->update($upit);
    }

    $upit = "SELECT id_film FROM film WHERE naziv_film = '$film' AND godina = $godina";
    $rezultat = $baza->selectdb($upit);
    list($id_film)=$rezultat->fetch_array();

    upis_osoba($redatelji, 1 , $id_film);
    upis_osoba($glumci, 2 , $id_film);
    upis_osoba($scenaristi, 3 , $id_film);

    foreach ($zanrovi as $zanr){
        $upit = "INSERT INTO zanrfilma VALUES ($id_film,$zanr)";
        $baza->update($upit);
    }

    echo json_encode(array("poruka"=>"Film je uspješno kreiran."));

}

function upis_osoba($polje, $uloga, $id_film){

    $baza = new baza();

    foreach ($polje as $red){
        $upit = "SELECT id_osoba FROM osoba WHERE naziv_osoba LIKE '$red'";
        $rez = $baza->selectdb($upit);

        if(!$rez->num_rows){// ne postoji ta osoba u Osoba
            $upit = "INSERT INTO osoba VALUES (default, '$red')";
            $baza->selectdb($upit);

            $upit = "SELECT id_osoba FROM osoba WHERE naziv_osoba LIKE '$red'";
            $rez = $baza->selectdb($upit);
            list($id_osoba)=$rez->fetch_array();

            $upit = "INSERT INTO filmosoba VALUES ($id_film, $id_osoba ,$uloga)";
            $baza->selectdb($upit);
        }else{
            list($id) = $rez->fetch_array();

            $upit = "SELECT * FROM filmosoba WHERE osoba_id = $id AND uloga_id = $uloga";
            $rez = $baza->selectdb($upit);

            if(!$rez->num_rows) {

                $upit = "INSERT INTO filmosoba VALUES ($id_film,$id,$uloga)";
                $baza->update($upit);
            }
        }
    }
}
