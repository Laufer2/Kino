<?php
require_once '_header.php';
require_once 'src/restrikcije.php';


$smarty->assign('Naslov_stranice',"Statistika");

$smarty->assign('statistika', "da");

$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

if($tip_korisnika < 2){
    $smarty->display('statistika.tpl');
}else{
    $smarty->display('zabrana.tpl');
}

$smarty->display('podnozje.tpl');