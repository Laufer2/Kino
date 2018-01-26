<?php

require_once '_header.php';

session_start();

$smarty->assign('proj', 'da');

$smarty->assign('Naslov_stranice',"Projekcija");

$smarty->display('head.tpl');

$smarty->display('projekcija.tpl');

$smarty->display('podnozje.tpl');