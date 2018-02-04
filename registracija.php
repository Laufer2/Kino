<?php
require_once '_header.php';
require_once 'src/restrikcije.php';


$smarty->assign('Naslov_stranice','Registracija');
$smarty->assign('registracija','da');

$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

if($tip_korisnika > 3){

    $smarty->display('forma_za_registraciju.tpl');

}

$smarty->display('podnozje.tpl');