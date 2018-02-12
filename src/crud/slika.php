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
    $id_rezervacija = filter_input(INPUT_POST,'id_rezervacija');

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    //novi zapis
    if($akcija < 4) {

        $rezervacija = filter_input(INPUT_POST, 'rezervacija');
        $naziv = filter_input(INPUT_POST, 'naziv');  // slika - obrada uploada slike
    }

    // padajući meniji za vanjske ključeve
    if ($selectmenu){

        $json['rezervacija'] = array();

        $upit = "SELECT * FROM rezervacija r JOIN korisnik k ON r.korisnik_id = k.id_korisnik
                  JOIN projekcija p ON r.projekcija_id = p.id_projekcija JOIN lokacija l ON p.lokacija_id = l.id_lokacija
                  JOIN film f ON p.film_id = f.id_film WHERE r.status = 1";

        $rezultat = $baza->selectdb($upit);
        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

            $polje = array(
                "id" => $red['id_rezervacija'],
                "naziv" => $red["korisnicko_ime"] . " - " . $red['naziv_film'] . " - " . date("d.m.Y, H:i", $red['dostupan_do']) . " - " . $red['naziv_lokacija']
            );

            array_push($json['rezervacija'], $polje);
        }
    }

    switch ($akcija){
        case 1://kreiranje

            $dir = "../slike/uploads/";
            $datoteka = $dir . basename($_FILES["naziv"]["name"]);

            if($_FILES['naziv']['error'] !== UPLOAD_ERR_NO_FILE) {

                //promjena imena slike
                if (file_exists($datoteka)) {

                    $json['datoteka'] = "postoji";

                    $tmp = explode(".", $_FILES["naziv"]["name"]);

                    $ime = round(microtime(true)) . '.' . end($tmp);

                    if (!move_uploaded_file($_FILES["naziv"]["tmp_name"], $dir . $ime)) {
                        echo json_encode(array("poruka" => "Slika nije dodana. Pokušajte ponovo.."));
                        exit();
                    }

                } else {
                    if (move_uploaded_file($_FILES["naziv"]["tmp_name"], $datoteka)) {
                        $ime = basename($_FILES["naziv"]["name"]);

                    } else {
                        echo json_encode(array("poruka" => "Slika nije dodana. Pokušajte ponovo."));
                        exit();
                    }
                }
            }else{
                echo json_encode(array("poruka" => "Pogreška prilikom dodavanje slike. Pokušajte ponovo."));
                exit();
            }

            $upit = "INSERT INTO slika VALUES (default, '$ime' , $rezervacija)";
            $rezultat = $baza->update($upit);

            break;

        case 2:// ažuriranje

            $upit = "UPDATE slika SET rezervacija_id = $rezervacija WHERE id_slika = $id";
            $rezultat = $baza->update($upit);
            break;

        case 3: // brisanje

            $dir = "../slike/uploads/";
            $datoteka = $dir . $naziv;
            if(file_exists($datoteka)){ // brisanje slike s diska
                chmod($datoteka, 0777);
                @unlink($datoteka);
            }
            $upit = "DELETE FROM slika WHERE id_slika = $id";
            $rezultat = $baza->update($upit);
            break;

        case 4: //dohvati jednoga za ažuriranje  -- poseno za projekciju
            $upit = "SELECT * FROM slika WHERE id_slika = $id AND rezervacija_id = $id_rezervacija";
            $rezultat = $baza->selectdb($upit);

            list($id, $naziv_slika, $rezervacija ) = $rezultat->fetch_array();
            $polje = array(
                "id" => $id,
                "rezervacija" => $rezervacija
            );

            array_push($json['podaci'],$polje);
            echo json_encode($json);
            exit();
    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM slika s JOIN rezervacija r ON s.rezervacija_id = r.id_rezervacija 
                  JOIN projekcija p ON r.projekcija_id = p.id_projekcija JOIN film f ON p.film_id = f.id_film
                  JOIN lokacija l ON p.lokacija_id = l.id_lokacija JOIN korisnik k ON r.korisnik_id = k.id_korisnik
                  WHERE k.korisnicko_ime LIKE '$pojam' OR f.naziv_film LIKE '$pojam' OR l.naziv_lokacija LIKE '$pojam' 
                  OR s.naziv_slika LIKE '$pojam'";

    }else {
        $broj_stranica = stranice_ispisa("rezervacija", $prikazi);

        $upit = "SELECT * FROM slika s JOIN rezervacija r ON s.rezervacija_id = r.id_rezervacija 
                  JOIN projekcija p ON r.projekcija_id = p.id_projekcija JOIN film f ON p.film_id = f.id_film
                  JOIN lokacija l ON p.lokacija_id = l.id_lokacija JOIN korisnik k ON r.korisnik_id = k.id_korisnik";
    }

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

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){

            $polje = array(
                "id" => $red['id_slika'],
                "rezervacija" => $red['rezervacija_id'],
                "korisnik" => $red['korisnicko_ime'],
                "naziv" => $red['naziv_slika'],
                "film" => $red["naziv_film"] . " (" . $red['godina'] . ") - " . date("d.m.Y, H:i", $red['dostupan_do']),
                "lokacija" => $red['naziv_lokacija']
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