<?php

require_once '_header.php';

session_start();

$smarty->assign('termini', 'da');

$smarty->assign('Naslov_stranice',"Termini");

$smarty->display('head.tpl');

$smarty->display('termini.tpl');

$smarty->display('podnozje.tpl');