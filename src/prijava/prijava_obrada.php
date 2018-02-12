<?php

require_once '../klase/baza.php';
require_once '../klase/datoteka.php';
require_once '../serverske_poruke.php';
require_once '../klase/korisnik.php';
require_once '../dnevnik_rada/dnevnik_rada.php';

function postavljenje_kolacica($korisnicko_ime, $zapamti_me){
    if($zapamti_me){
        setcookie('kino',$korisnicko_ime);
    }else{
        setcookie('kino',$korisnicko_ime, time()-3600);
    }
}

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST') {

    $korisnicko_ime = htmlspecialchars(filter_input(INPUT_POST, 'korisnicko_ime', FILTER_SANITIZE_STRING));
    $lozinka = htmlspecialchars(filter_input(INPUT_POST, 'lozinka', FILTER_SANITIZE_STRING));
    $zapamti_me = filter_input(INPUT_POST, 'zapamti_me');

    $dat = new datoteka();
    $trajanje_kolacica = $dat->dohvati('trajanje_kolacica');
    $pomak = $dat->dohvati('pomak');
    $max_nesupjesne_prijave = $dat->dohvati('neuspjesne_prijave');

    $upit = "SELECT id_korisnik, tip_id, lozinka, ime, prezime, email, aktivacijski_rok,
              neuspjesne_prijave, aktivacijski_kod, status_aktivacije FROM korisnik WHERE korisnicko_ime = '$korisnicko_ime';";

    $baza = new baza();
    $podaci = $baza->selectdb($upit);

    if($podaci->num_rows == 0){
        posalji_poruku("Pogrešno korisničko ime.");
        exit();

    }else{

        list($id_korisnik, $tip_id, $lozinka_iz_baze, $ime, $prezime,
            $email, $aktivacijski_rok, $uzastopne_neuspjesne_prijave, $akt_kod, $status_aktivacije) = $podaci->fetch_array();

        //istekao rok
        if($status_aktivacije == 0){
            if($aktivacijski_rok <= (time() + ($pomak * 60 * 60))){

                $uri = $_SERVER["REQUEST_URI"];
                $pos = strrpos($uri, "/");
                $dir = $_SERVER["HTTP_HOST"] . substr($uri, 0, $pos - 11);
                $url = "http://" . $dir . "aktivacija.php?kod=$akt_kod";

                posalji_poruku("",$url);
                exit();
            }else{
                posalji_poruku("Vaš račun nije aktiviran. Aktivirajte račun pomoću aktivacijskog linka 
                    koji je poslan na vašu e-mail adresu prilikom registracije.");
                exit();
            }
        }

        //račun aktiviran, al blokiran
        if($status_aktivacije == 2){
            posalji_poruku("Vaš račun je zaključan. Kontaktirajte administratora.");
            exit();
        }

        //neuspješna prijava - dobar korime, pogrešna lozinka
        if( $status_aktivacije == 1 && $lozinka_iz_baze != $lozinka){

            $upit2 = "UPDATE korisnik SET neuspjesne_prijave = neuspjesne_prijave + 1 WHERE korisnicko_ime = '$korisnicko_ime'";

            if($baza->update($upit2))
            {
                posalji_poruku("Pogrešna lozinka.");

                if(($uzastopne_neuspjesne_prijave + 1) >= $max_nesupjesne_prijave){

                    $upit = "UPDATE korisnik SET status_aktivacije = 2 WHERE korisnicko_ime = '$korisnicko_ime'";
                    $baza->update($upit);

                    dnevnik("Zaključavanje računa",1, $id_korisnik);
                }
            }else{
                posalji_poruku("Dogodila se greška. Pokušajte ponovo.");
            }

            //Log neuspješnu prijavu
            dnevnik("Neuspješna prijava",1, $id_korisnik);

        }else{

            //uspješna prijava

            //reset neuspješnih prijava
            if($uzastopne_neuspjesne_prijave > 0){
                $upit = "UPDATE korisnik SET neuspjesne_prijave = 0 WHERE  korisnicko_ime = '$korisnicko_ime'";
                $baza->update($upit);
            }

            postavljenje_kolacica($korisnicko_ime, $zapamti_me);
            $korisnik = new korisnik();
            $virtualno_vrijeme = time() + ($pomak * 60 * 60);

            $korisnik->set_podaci($id_korisnik, $tip_id, $ime, $prezime, $email, $korisnicko_ime, $virtualno_vrijeme);
            //stvori sesiju

            if(!isset($_SESSION))
            {
                session_start();
            }
            $_SESSION['kino'] = $korisnik;

            $uri = $_SERVER["REQUEST_URI"];
            $pos = strrpos($uri, "/");
            $dir = $_SERVER["HTTP_HOST"] . substr($uri, 0, $pos - 11);
            $url = "http://" . $dir . "index.php";

            dnevnik("Prijava",1, $id_korisnik);

            posalji_poruku("",$url);

        }
    }
}