<?php

require_once '../klase/baza.php';
require_once '../klase/datoteka.php';
require_once '../serverske_poruke.php';

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD')=='POST'){

    $ime = htmlspecialchars(filter_input(INPUT_POST, 'ime', FILTER_SANITIZE_STRING));
    $prezime = htmlspecialchars(filter_input(INPUT_POST, 'prezime', FILTER_SANITIZE_STRING));
    $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $korisnicko_ime = htmlspecialchars(filter_input(INPUT_POST, 'korisnicko_ime', FILTER_SANITIZE_STRING));
    $lozinka = htmlspecialchars(filter_input(INPUT_POST, 'lozinka', FILTER_SANITIZE_STRING));
    $ponovljena_lozinka = htmlspecialchars(filter_input(INPUT_POST, 'ponovo_lozinka', FILTER_SANITIZE_STRING));

    if(isset($_POST['g-recaptcha-response'])){
        $captcha = $_POST['g-recaptcha-response'];
    }
    if(!$captcha){
        posalji_poruku("Označite recaptcha formu.");
        exit();
    }

    $tajni_kljuc = "6LejmEUUAAAAAO7Th2bUQFHok679t-knpd8XfESI";
    $ip = $_SERVER['REMOTE_ADDR'];
    $odgovor = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$tajni_kljuc."&response=".$captcha."&remoteip=".$ip);
    $kljuc_odgovora = json_decode($odgovor,true);

    if($kljuc_odgovora["success"] !== true) {

        posalji_poruku("Automatu, išššš, išššš!.");

    } else {

        /*
        if(!preg_match("/^[a-zA-Z0-9.!#$%&’*+/?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $email)){
           posalji_poruku("Nepravilno strukturirana e-mail adresa.");
           exit();
        }*/

        $upit = "SELECT * FROM korisnik WHERE email = '$email';";
        $baza = new baza();

        $rezultat = $baza->selectdb($upit);
        if($rezultat->num_rows != 0){
            posalji_poruku( "Već postoji korisnički račun s navedenom e-mail adresom.");
            exit();
        }

        if(strcmp($lozinka, $ponovljena_lozinka) != 0) {
            posalji_poruku("Lozinke nisu jednake");
            exit();
        }

        if (strlen($korisnicko_ime) < 4){
            posalji_poruku("Korisnicko ime mora imati min 4 znaka.");
            exit();
        }

        /*lozinka mora imati veliko slovo te broj*/

        $dat = new datoteka();
        $rok_trajanja_aktivacijskog_koda = $dat->dohvati('rok_trajanja_aktivacijskog_linka');
        $pomak = $dat->dohvati("pomak");

        if($rok_trajanja_aktivacijskog_koda !== false){
            $aktivacijski_rok = time() + ($pomak*60*60) + ($rok_trajanja_aktivacijskog_koda*60*60) ;
        }else{
            posalji_poruku("Nemoguće dohvatiti konfiguracijsku datoteku sustava.");
            exit();
        }

        $aktivacijski_kod = sha1($email . $aktivacijski_rok);

        $upit = "INSERT INTO korisnik(korisnicko_ime, lozinka, email, ime, prezime, aktivacijski_kod, aktivacijski_rok ) VALUES 
                  ('$korisnicko_ime', '$lozinka', '$email', '$ime', '$prezime', '$aktivacijski_kod', '$aktivacijski_rok');";

        //slanje aktivacijskog mail-a

        if($baza->update($upit)){

            $uri = $_SERVER["REQUEST_URI"];
            $pos = strrpos($uri, "/");
            $dir = $_SERVER["HTTP_HOST"] . substr($uri, 0, $pos - 16);
            $url = "http://" . $dir . "aktivacija.php?kod=$aktivacijski_kod";

            $naslov = "Molimo Vas aktivirajte vaš račun";
            $poruka = "Uspješno ste se registrirali na Kino.org. <br/> <br/>"
                ."Vaše korisničko ime: $korisnicko_ime <br/>"
                ."Vaša lozinka: $lozinka <br/><br/>"
                ."Aktivirajte Vaš račun klikom na <a href='$url'>aktivacijski link.</a>";

            if(posalji_mail($email, $naslov, $poruka)){
                posalji_poruku("Uspješno ste se registrirali. Aktivacijski mail je poslan na '$email' <br>
                                Rok za aktivaciju vašeg računa iznosi $rok_trajanja_aktivacijskog_koda h.");
            }else{
                posalji_poruku("Aktivacijski mail nije poslan. Kontaktirajte administratora.");
            }
        }else{
            posalji_poruku("Pogreška prilikom upisa u bazu. Pokušajte ponovo.");
        }
    }
}

