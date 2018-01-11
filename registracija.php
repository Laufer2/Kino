<?php
require_once '_header.php';

$title = "Registracija";
$korisnicko_provjera = "da";

$smarty->assign('Naslov_stranice',$title);
$smarty->assign('korisnicko', $korisnicko_provjera);

$smarty->display('head.tpl');

$smarty->display('forma_za_registraciju.tpl');

$smarty->display('podnozje.tpl');