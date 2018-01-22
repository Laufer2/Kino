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
    $status = filter_input(INPUT_POST, 'status');

    $baza = new baza();
    $dat = new datoteka();

    $prikazi = $dat->dohvati('prikazi_po_stranici');

    $poruka = $broj_stranica = 0;
    $json = array();
    $json['podaci'] = array();

    //novi zapis
    if($akcija < 3) {

        $korisnicko = filter_input(INPUT_POST, 'korisnicko');
        $email = filter_input(INPUT_POST, 'email',FILTER_SANITIZE_EMAIL);
        $lozinka = filter_input(INPUT_POST, 'lozinka');
        $ime = filter_input(INPUT_POST, 'ime');
        $prezime = filter_input(INPUT_POST, 'prezime');
        $tipkorisnika = filter_input(INPUT_POST, 'tipkorisnika');
        $neuspjesne_prijave = filter_input(INPUT_POST,'neuspjesne_prijave');
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
            $rok_trajanja_aktivacijskog_koda = $dat->dohvati('rok_trajanja_aktivacijskog_linka');
            $pomak = $dat->dohvati("pomak");

            if($rok_trajanja_aktivacijskog_koda !== false){
                $aktivacijski_rok = time() + ($pomak*60*60) + ($rok_trajanja_aktivacijskog_koda*60*60) ;
            }

            $akt_kod = sha1($email . $aktivacijski_rok);
            $upit = "INSERT INTO korisnik VALUES (default, $tipkorisnika, '$korisnicko', '$lozinka', 
                    '$email', '$ime', '$prezime', '$akt_kod', $status, $aktivacijski_rok, $neuspjesne_prijave)";
            $rezultat = $baza->update($upit);
            break;

        case 2:// ažuriranje

            $upit = "UPDATE korisnik SET tip_id = $tipkorisnika, korisnicko_ime = '$korisnicko', status_aktivacije = $status, email = '$email', 
                    ime = '$ime', prezime = '$prezime' WHERE id_korisnik = $id";
            $rezultat = $baza->update($upit);

            if($tipkorisnika == 3){
                $upit = "DELETE FROM moderatorlokacije WHERE korisnik_id = $id";
                $rezultat = $baza->update($upit);
            }
            $json['upit'] = $upit;
            break;

        case 3: // brisanje
            $upit = "DELETE FROM korisnik WHERE id_korisnik = $id";
            $rezultat = $baza->update($upit);
            break;

        case 4: //dohvati jednoga za ažuriranje
            $upit = "SELECT * FROM korisnik WHERE id_korisnik = $id";
            $rezultat = $baza->selectdb($upit);

            list($id_korisnik, $tip_id, $korisnicko_ime, $lozinka, $email, $ime, $prezime, $akt_kod,
                $status_aktivacije, $akt_rok, $neuspjesne_prijave) = $rezultat->fetch_array();
            $polje = array(
                "id" => $id,
                "tipkorisnika" => $tip_id,
                "email" => $email,
                "ime" => $ime,
                "prezime" => $prezime,
                "korisnicko" => $korisnicko_ime,
                "lozinka" => $lozinka,
                "status" => $status_aktivacije,
                "neuspjesne_prijave" => $neuspjesne_prijave
            );
            array_push($json['podaci'],$polje);
            echo json_encode($json);
            exit();
        case 6: // promjena status računa
            $upit = "UPDATE korisnik SET status_aktivacije = $status, neuspjesne_prijave = 0 WHERE id_korisnik = $id";
            $rezultat = $baza->update($upit);
            break;
    }

    $offset = ($aktivna_stranica > 0 ? $prikazi*$aktivna_stranica : 0);

    if ($akcija == 5 && $pojam != ""){ // search

        $pojam = "%" . $pojam . "%";
        $upit = "SELECT * FROM korisnik k JOIN tipkorisnika t ON k.tip_id = t.id_tipkorisnika WHERE k.korisnicko_ime LIKE '$pojam' OR 
                  t.naziv_tipkorisnika LIKE '$pojam' OR k.email LIKE '$pojam' OR k.ime LIKE '$pojam' OR k.prezime LIKE '$pojam'";
        if(isset($stupac) && $stupac != "" ) {
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
        $broj_stranica = stranice_ispisa("korisnik", $prikazi);

        $upit = "SELECT * FROM korisnik k JOIN tipkorisnika t ON k.tip_id = t.id_tipkorisnika";
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

    if($rezultat = $baza->selectdb($upit)){

        while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)){
            switch($red['status_aktivacije']){
                case 0:
                    $red['status_aktivacije'] = "Neaktiviran";
                    break;
                case 1:
                    $red['status_aktivacije'] = "Aktiviran";
                    break;
                case 2:
                    $red['status_aktivacije'] = "Zaključan";
            }

            switch($red['tip_id']){
                case 1:
                    $red['tip_id'] = "Administrator";
                    break;
                case 2:
                    $red['tip_id'] = "Moderator";
                    break;
                case 3:
                    $red['tip_id'] = "Korisnik";
            }

            $polje = array(
                "id" => $red['id_korisnik'],
                "tipkorisnika" => $red['tip_id'],
                "korisnicko" => $red['korisnicko_ime'],
                "status" => $red['status_aktivacije'],
                "email" => $red['email'],
                "lozinka" => md5($red['lozinka']),
                "ime" => $red['ime'],
                "prezime" => $red['prezime'],
                "akt_rok" => date("F j, Y, H:i",$red['aktivacijski_rok']),
                //"akt_kod" => $red['aktivacijski_kod'],
                "neuspjesne_prijave" => $red['neuspjesne_prijave']
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