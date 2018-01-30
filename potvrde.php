<?php

require_once '_header.php';
require_once 'src/klase/korisnik.php';
require_once 'src/restrikcije.php';

$smarty->assign('Naslov_stranice',"Potvrde");
$smarty->assign('jquery_ui',"da");

$smarty->assign('potvrde','da');

$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

if($tip_korisnika < 3){
    $smarty->display('potvrde.tpl');
}else{
    $smarty->display('zabrana.tpl');
}

$smarty->display('podnozje.tpl');
