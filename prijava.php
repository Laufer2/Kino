<?php
require_once '_header.php';
require_once 'baza.php';
require_once 'datoteka.php';

$title = "Prijava";

$prijava = "da";

$smarty->assign('prijava',$prijava);

$smarty->assign('Naslov_stranice', $title);

$smarty->display('head.tpl');

$smarty->display('forma_za_prijavu.tpl');

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST') {

    $korisnicko_ime = htmlspecialchars(filter_input(INPUT_POST, 'korisnicko_ime', FILTER_SANITIZE_STRING));
    $lozinka = htmlspecialchars(filter_input(INPUT_POST, 'lozinka', FILTER_SANITIZE_STRING));
    $zapamti_me = htmlspecialchars(filter_input(INPUT_POST, 'zapamti_me', FILTER_SANITIZE_STRING));

    $dat = new datoteka();
    $trajanje_kolacica = $dat->dohvati('trajanje_kolacica');

    if($zapamti_me == 1){
        setcookie('kino',$korisnicko_ime, time() + ($trajanje_kolacica * 24 * 60 * 60));
    }else{
        setcookie("kino", $korisnicko_ime, time() - 3600);
    }

    $upit = "SELECT id_korisnik, tip_id, lozinka, ime, prezime, email, aktivacijski_rok,
              neuspjesne_prijave, aktivacijski_kod, status_aktivacije FROM korisnik WHERE korisnicko_ime = '$korisnicko_ime';";

    $baza = new baza();
    $podaci = $baza->selectdb($upit);
    $korisnik = array();
    $lozinka_iz_baze = $akt_kod = $status_aktivacije = "";

    $dat = new datoteka();
    $pomak = $dat->dohvati('pomak');

    $nesupjesne_prijave = $dat->dohvati('neuspjesne_prijave');


    if($podaci->num_rows == 0){
        posalji_poruku("Pogrešno korisničko ime i/ili lozinka.");
        exit();

    }else{

        while ($polje = $podaci->fetch_array()){
            $korisnik['id_korisnik'] = $polje[0];
            $korisnik['tip_id'] = $polje[1];
            $lozinka_iz_baze = $polje[2];
            $korisnik['ime'] = $polje[3];
            $korisnik['prezime'] = $polje[4];
            $korisnik['email'] = $polje[5];
            $korisnik['aktivacijski_rok'] = $polje[6];
            $korisnik['neuspjesne_prijave'] = $polje[7];
            $akt_kod = $polje[8];
            $status_aktivacije = $polje[9];
        }

        //istekao rok
        //prikaz email boxa
        if($korisnik['aktivacijski_rok'] <= (time() + ($pomak * 60 * 60))){
            header("Location: http://localhost:8000/kino/aktivacija.php?kod=$akt_kod");
            exit();
        }

        //rok nije istekao ali račun nije aktiviran status = 0
        // prikaz email boxa
        if($korisnik['aktivacijski_rok'] >= (time() + ($pomak * 60 * 60)) && $status_aktivacije == 0){
            header("Location: http://localhost:8000/kino/aktivacija.php?kod=$akt_kod?status_aktivacije=$status_aktivacije");
            exit();
        }

        //račun aktiviran, al blokiran - max neuspjesne prijave, status = 2
        //poruka - Račun zaključan. kontakt admina
        if($korisnik['aktivacijski_rok'] >= (time() + ($pomak * 60 * 60)) && $status_aktivacije == 2){
            header("Location: http://localhost:8000/kino/aktivacija.php?kod=$akt_kod?status_aktivacije=$status_aktivacije");
            exit();
        }

        //UZASTOPNE neuspješne prijave - nakon uspješne prijave - ne_prijave staviti na 0
        //Povećanje ne_prijava samo ako su ne_prijave > 0

        //neuspješna prijava - dobar korime, pogrešna lozinka
        if($korisnik['aktivacijski_rok'] >= (time() + ($pomak * 60 * 60)) && $status_aktivacije == 1){

            if($lozinka_iz_baze != $lozinka){

                if($korisnik['neuspjesne_prijave'] > 0){
                    $upit = "UPDATE korisnik SET neuspjesne_prijave = neuspjesne_prijave + 1 WHERE $korisnicko_ime = korisnicko_ime";
                    $baza->update($upit);

                    //Log neuspješnu prijavu

                    if(($korisnik['neuspjesne_prijave'] + 1) == $nesupjesne_prijave){

                        $upit = "UPDATE korisnik SET status_aktivacije = 2 WHERE $korisnicko_ime = korisnicko_ime";
                        $baza->update($upit);
                    }
                }
            }
        }
    }
}


if(filter_has_var(INPUT_GET, 'kolacic')){

    if(filter_input(INPUT_COOKIE,'kino') !== null){
        posalji_poruku(filter_input(INPUT_COOKIE,'kino'));
    }else{
        posalji_poruku("");
    }
}

$smarty->display('podnozje.tpl');
