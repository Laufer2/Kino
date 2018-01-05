<?php
require_once '_header.php';

$title = "Registracija";
$jquery = "da";
$korisnicko_provjera = "da";

$smarty->assign('Naslov_stranice',$title);
$smarty->assign('jquery', $jquery);
$smarty->assign('korisnicko', $korisnicko_provjera);

$smarty->display('head.tpl');

$smarty->display('forma_za_registraciju.tpl');

$smarty->display('podnozje.tpl');