<?php
require_once 'src/restrikcije.php';
require_once '_header.php';

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$tip_korisnika = restrikcije($smarty);

echo $tip_korisnika;

$smarty->display('navigacija.tpl');

if($tip_korisnika < 4){
    $smarty->assign('naslovnica_prijavljeni',"da");
}

$smarty->display('naslovnica.tpl');

$smarty->display('podnozje.tpl');