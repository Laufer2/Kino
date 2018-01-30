<?php
require_once '_header.php';


$smarty->assign('Naslov_stranice',"Registracija");

$smarty->assign('korisnicko', "da");

$smarty->display('head.tpl');

$smarty->display('forma_za_registraciju.tpl');

$smarty->display('podnozje.tpl');