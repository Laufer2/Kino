<?php
require_once '_header.php';
require_once 'src/restrikcije.php';

$smarty->assign('Naslov_stranice',"Dokumentacija");

$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

$smarty->display('o_autoru.tpl');

$smarty->display('podnozje.tpl');