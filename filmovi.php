<?php
require_once '_header.php';


$smarty->assign('Naslov_stranice',"Filmovi");
$smarty->assign('filmovi', "da");

$smarty->display('head.tpl');

$smarty->display('filmovi.tpl');

$smarty->display('podnozje.tpl');