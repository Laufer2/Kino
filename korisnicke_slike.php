<?php
require_once '_header.php';
require_once 'src/klase/korisnik.php';
require_once 'src/restrikcije.php';

$smarty->assign('Naslov_stranice',"Korisničke slike");
$smarty->assign('korisnicke_slike','da');


$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

if($tip_korisnika < 4){
    $smarty->display('korisnicke_slike.tpl');

}else{
    $smarty->display('zabrana.tpl');
}

$smarty->display('podnozje.tpl');