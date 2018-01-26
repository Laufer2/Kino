<?php

require_once '_header.php';
require_once 'src/klase/korisnik.php';

$smarty->assign('Naslov_stranice',"Rezervacije");
$smarty->assign('rezervacije','da');

$smarty->display('head.tpl');

$smarty->display('rezervacije_korisnik.tpl');

$smarty->display('podnozje.tpl');