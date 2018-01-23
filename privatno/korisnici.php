<?php

require_once '../_header.php';

$smarty->assign('Naslov_stranice',"Korisnici");

$smarty->assign('privatno',"da");

$smarty->setTemplateDir('../templates');

$smarty->setCompileDir('../templates_c');

$smarty->display('head.tpl');

$smarty->display('korisnici.tpl');

$smarty->display('podnozje.tpl');