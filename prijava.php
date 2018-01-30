<?php
require_once '_header.php';


$smarty->assign('prijava',"da");

$smarty->assign('Naslov_stranice', "Prijava");

$smarty->display('head.tpl');

$smarty->display('forma_za_prijavu.tpl');

$smarty->display('podnozje.tpl');