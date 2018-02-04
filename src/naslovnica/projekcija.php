<?php

require_once '../klase/baza.php';
require_once '../klase/datoteka.php';
require_once '../dnevnik_rada/dnevnik_rada.php';
require_once '../statistike/evidencija.php';

$id = filter_input(INPUT_POST,'id');

$dat = new datoteka();
$baza = new baza();
$json = array();
$json['projekcija'] = array();

$upit = "SELECT p.id_projekcija, p.dostupan_do, p.dostupan_od, p.max_gledatelja, f.naziv_film, f.godina, f.trajanje, f.sadrzaj, f.id_film, l.naziv_lokacija,
          (SELECT SUM(r.broj_rezervacija)  FROM rezervacija r WHERE r.status = 1 AND r.projekcija_id = p.id_projekcija) as ostalo
          FROM projekcija p JOIN film f ON p.film_id = f.id_film JOIN lokacija l ON p.lokacija_id = l.id_lokacija 
          WHERE  p.id_projekcija = $id";
dnevnik($upit, 2, 0);

$rezultat = $baza->selectdb($upit);

while ($red = $rezultat->fetch_array(MYSQLI_ASSOC)) {

    $polje = array(
        "id" => $red['id_projekcija'],
        "lokacija" => $red['naziv_lokacija'],
        "naziv" => $red['naziv_film'],
        "trajanje" => $red['trajanje'],
        "sadrzaj" => $red['sadrzaj'],
        "max_gledatelja" => $red['max_gledatelja'],
        "dostupan_od" => date("d.m.Y, H:i", $red['dostupan_od']),
        "pocetak" => date("d.m.Y, H:i", $red['dostupan_do']),
        "ostalo" => ($red['max_gledatelja'] - $red['ostalo'])
    );

    $id_projekcija = $red['id_projekcija'];
    $id_filma = $red['id_film'];
    $dotupan_od = $red['dostupan_od'];
    $max = $red['max_gledatelja'];

    $polje['zanr'] = array();
    $polje['redatelj'] = array();
    $polje['glumci'] = array();
    $polje['scenarist'] = array();

    $upit = "SELECT z.naziv_zanr FROM zanr z JOIN zanrfilma z2 ON z.id_zanr = z2.zanr_id  WHERE z2.film_id = $id_filma";
    dnevnik($upit, 2, 0);

    $rez = $baza->selectdb($upit);
    while ($row = $rez->fetch_array(MYSQLI_ASSOC)) {

        array_push($polje['zanr'], $row['naziv_zanr']);

    }

    $upit = "SELECT o.naziv_osoba FROM osoba o JOIN filmosoba f ON o.id_osoba = f.osoba_id JOIN tipuloga t ON f.uloga_id = t.id_tipuloga 
                     WHERE f.film_id = $id_filma AND t.naziv_tipuloga = 'Redatelj'";

    $rez = $baza->selectdb($upit);

    while ($row = $rez->fetch_array(MYSQLI_ASSOC)) {

        array_push($polje['redatelj'], $row['naziv_osoba']);

    }
    $json['upit']=$upit;

    $upit = "SELECT o.naziv_osoba FROM osoba o JOIN filmosoba f ON o.id_osoba = f.osoba_id JOIN tipuloga t ON f.uloga_id = t.id_tipuloga 
                     WHERE f.film_id = $id_filma AND t.naziv_tipuloga = 'Glumac'";

    $rez = $baza->selectdb($upit);

    if($rez->num_rows) {
        while ($row = $rez->fetch_array(MYSQLI_ASSOC)) {

            array_push($polje['glumci'], $row['naziv_osoba']);

        }
    }

    $upit = "SELECT o.naziv_osoba FROM osoba o JOIN filmosoba f ON o.id_osoba = f.osoba_id JOIN tipuloga t ON f.uloga_id = t.id_tipuloga 
                     WHERE f.film_id = $id_filma AND t.naziv_tipuloga = 'Scenarist'";

    $rez = $baza->selectdb($upit);
    while ($row = $rez->fetch_array(MYSQLI_ASSOC)) {

        array_push($polje['scenarist'], $row['naziv_osoba']);

    }

    //provjera dostupnih mjesta - odobrene rezervacije

    $pomak = $dat->dohvati('pomak');
    $virtualno_vrijeme = time() + ($pomak * 60 * 60);
    if( $dotupan_od > $virtualno_vrijeme){

        $json['poruka'] = "Rezervacijama možete pristupiti tek " .date("d.m.Y, H:i", $red['dostupan_do']);

    }

    array_push($json['projekcija'], $polje);
}

echo json_encode($json);