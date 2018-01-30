<?php
require_once '_header.php';
require_once 'src/restrikcije.php';


$smarty->assign('Naslov_stranice','Lokacije');

$smarty->assign('lokacije','da');


$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

if($tip_korisnika < 4){
    $smarty->display('lokacije.tpl');
}else{
    $smarty->display('zabrana.tpl');
}

$smarty->display('podnozje.tpl');