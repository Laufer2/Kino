<?php
require_once '_header.php';
require_once 'src/restrikcije.php';


$smarty->assign('Naslov_stranice',"Aplikativna statistika");

$smarty->assign('app_statistika', "da");

$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

if($tip_korisnika < 3){
    $smarty->display('app_statistika.tpl');
}else{
    $smarty->display('zabrana.tpl');
}

$smarty->display('podnozje.tpl');