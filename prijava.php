<?php
require_once '_header.php';


$title = "Prijava";

$prijava = "da";

$smarty->assign('prijava',$prijava);

$smarty->assign('Naslov_stranice', $title);

$smarty->display('head.tpl');

$smarty->display('forma_za_prijavu.tpl');

$smarty->display('podnozje.tpl');