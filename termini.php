<?php

require_once '_header.php';
require_once 'src/restrikcije.php';


$smarty->assign('termini', 'da');

$smarty->assign('Naslov_stranice',"Termini");

$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

if($tip_korisnika < 3){
    $smarty->display('termini.tpl');
}else{
    $smarty->display('zabrana.tpl');
}

$smarty->display('podnozje.tpl');