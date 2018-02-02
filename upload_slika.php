<?php
require_once 'src/restrikcije.php';
require_once '_header.php';

$smarty->assign('upload_slika','da');

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$tip_korisnika = restrikcije($smarty);

echo $tip_korisnika;

$smarty->display('navigacija.tpl');

if($tip_korisnika < 4){
    $smarty->display('upload_slika.tpl');
}else{
    $smarty->display('zabrana.tpl');
}

$smarty->display('podnozje.tpl');
