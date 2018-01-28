<?php

require_once '_header.php';
require_once 'src/klase/korisnik.php';

$smarty->assign('Naslov_stranice',"Potvrde");
$smarty->assign('jquery_ui',"da");

$smarty->assign('potvrde','da');

$smarty->display('head.tpl');

$smarty->display('potvrde.tpl');

$smarty->display('podnozje.tpl');
