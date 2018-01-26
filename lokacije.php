<?php
require_once '_header.php';


$smarty->assign('Naslov_stranice','Lokacije');
$smarty->assign('lokacije','da');

$smarty->display('head.tpl');

$smarty->display('lokacije.tpl');

$smarty->display('podnozje.tpl');