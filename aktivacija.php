<?php

require_once 'baza.php';
require_once 'serverske_poruke.php';
require_once '_header.php';
require_once 'datoteka.php';

$title = "Aktivacija";
$novi_akt_link = "da";

$smarty->assign("Naslov_stranice",$title);
$smarty->assign('novi_aktivacijski_link',$novi_akt_link);

$smarty->display('head.tpl');
$smarty->display('zaglavlje.tpl');


if(filter_input(INPUT_GET, 'kod') !== null){

    $aktivacijski_kod = filter_input(INPUT_GET, 'kod');

    $dat = new datoteka();
    $pomak = $dat->dohvati("pomak");

    $baza = new baza();
    $upit = "SELECT aktivacijski_rok FROM korisnik WHERE aktivacijski_kod = '$aktivacijski_kod'";

    if ( $podaci = $baza->selectdb($upit)){

        $akt = $podaci->fetch_array();
        $akt_rok = $akt['aktivacijski_rok'];

        //ako nije istekao
        if ($akt_rok >= (time() + ($pomak*60*60))){

            $a = time() + ($pomak*60*60);

            $upit = "UPDATE Korisnik SET status_aktivacije = 1 WHERE aktivacijski_kod='$aktivacijski_kod'";
            $baza->update($upit);

            $smarty->assign('poruka','Uspješno ste aktivirali korisnički račun. Možete se prijaviti sa svojim podacima.');

        }else{
            $smarty->assign('rok_istekao','Rok za aktivaciju je istekao. Unesite e-mail za ponovno slanje aktivacijskog linka.');

        }
    }
}

$smarty->display('aktivacija.tpl');
$smarty->display('podnozje.tpl');