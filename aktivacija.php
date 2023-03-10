<?php

require_once 'src/klase/baza.php';
require_once 'src/serverske_poruke.php';
require_once '_header.php';
require_once 'src/klase/datoteka.php';

$title = "Aktivacija";
$novi_akt_link = "da";

$smarty->assign("Naslov_stranice",$title);
$smarty->assign('novi_aktivacijski_link',$novi_akt_link);
$smarty->assign('Lurker',"da");

$smarty->display('head.tpl');
$smarty->display('zaglavlje.tpl');
$smarty->display('navigacija.tpl');

if(filter_input(INPUT_GET, 'kod') !== null){

    $aktivacijski_kod = filter_input(INPUT_GET, 'kod');

    $dat = new datoteka();
    $pomak = $dat->dohvati("pomak");

    $baza = new baza();
    $upit = "SELECT aktivacijski_rok, status_aktivacije FROM korisnik WHERE aktivacijski_kod = '$aktivacijski_kod'";

    if ( $podaci = $baza->selectdb($upit)){

        $akt = $podaci->fetch_array();
        $akt_rok = $akt['aktivacijski_rok'];
        $status_aktivacije = $akt['status_aktivacije'];

        //ako nije istekao
        if ($akt_rok >= (time() + ($pomak*60*60)) && $status_aktivacije != 2){

            $upit = "UPDATE korisnik SET status_aktivacije = 1 WHERE aktivacijski_kod='$aktivacijski_kod'";
            $baza->update($upit);

            $smarty->assign('poruka', ' Uspješno ste aktivirali korisnički račun. Možete se prijaviti sa svojim podacima.');

        }else if($status_aktivacije != 2){
            $smarty->assign('rok_istekao',' Rok za aktivaciju je istekao. Unesite e-mail za ponovno slanje aktivacijskog linka.' );

        }else{
            $smarty->assign('poruka', ' Vaš račun je zaključan. Kontaktirajte administratora.' );
        }
    }
}
$smarty->display('aktivacija.tpl');
$smarty->display('podnozje.tpl');