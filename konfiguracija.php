<?php

//check if admin

require_once '_header.php';



$smarty->assign('Naslov_stranice',"Konfiguracija");
$smarty->assign('konfiguracija',"da");


$smarty->display('head.tpl');

$smarty->display('konfiguracija.tpl');

$smarty->display('podnozje.tpl');