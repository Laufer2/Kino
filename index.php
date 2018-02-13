<?php
require_once 'src/restrikcije.php';
require_once '_header.php';

$smarty->assign('Naslov_stranice','Naslovnica');

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$tip_korisnika = restrikcije($smarty);

$smarty->display('navigacija.tpl');

if($tip_korisnika < 4){

    $smarty->assign('naslovnica_prijavljeni',"da");

}else{

    $smarty->assign('naslovnica_neprijavljeni',"da");
}

$smarty->display('naslovnica.tpl');

$smarty->display('podnozje.tpl');