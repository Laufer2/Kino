<?php

require_once '../klase/baza.php';
require_once '../serverske_poruke.php';
require_once '../dnevnik_rada/dnevnik_rada.php';

function kolacic($korisnicko_ime, $trajanje, $zapamti_me){
    if($zapamti_me == 1){
        setcookie('kino',$korisnicko_ime, time() + ($trajanje * 24 * 60 * 60));
    }else{
        setcookie("kino", $korisnicko_ime, time() - 3600);
    }
}

if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST'){

    $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    $upit = "SELECT id_korisnik, korisnicko_ime FROM korisnik WHERE email = '$email';";

    $baza = new baza();

    $rezultat = $baza->selectdb($upit);
    list($id, $kor_ime) = $rezultat->fetch_array();

    if($rezultat->num_rows > 0){

        $nova_lozinka = generiraj_lozinku();

        $upit = "UPDATE korisnik SET lozinka = '$nova_lozinka' WHERE email = '$email'";
        dnevnik("Nova lozinka", 1, $id);

        if($baza->update($upit)){
            $naslov = "Nova lozinka za Kino.org";

            $poruka = "Za vaš račun je generirana nova lozinka. <br><br>";
            $poruka .= "Korisničko ime: " . $kor_ime . "<br>";
            $poruka .= "Nova lozinka: " . $nova_lozinka;
            dnevnik("Nova lozinka",1, $id);
            posalji_mail($email,$naslov,$poruka);

            posalji_poruku("Na vašu e-mail adresu poslana je nova lozinka." );
        }else{
            posalji_poruku("Dogodila se greška. Pokušajte ponovo" );
        }

    }else{

        posalji_poruku("Ne postoji korisnik s tom e-mail adresom.");

    }
}

function generiraj_lozinku(){
        $brojevi = '123456789';
        $mala_slova = 'abcdđefghijklmnopqrstuvwxyz';
        $velika_slova = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
        $lozinka = '';
        for ($i = 0; $i < 3; $i++) {
            $lozinka .= $brojevi[rand(0, strlen($brojevi) - 1)];
            $lozinka .= $mala_slova[rand(0, strlen($mala_slova) - 1)];
            $lozinka .= $velika_slova[rand(0, strlen($velika_slova) - 1)];
        }
        return $lozinka;
}