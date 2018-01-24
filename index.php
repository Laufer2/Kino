<?php
require_once 'src/klase/korisnik.php';
require_once '_header.php';

session_start();

echo "Ovo je naslovnica. Dobrodošli ";


$smarty->display('head.tpl');
$smarty->display('zaglavlje.tpl');

if (!isset($_SESSION['kino'])){
    $tip_korisnika = 0;
}else{
    $tip_korisnika = $_SESSION['kino']->getTipId();
}

echo $tip_korisnika;

//koja navigacija će se ispisati
switch ($tip_korisnika){
    case 3:
        $smarty->assign('Korisnik',"1");
        break;
    case 2:
        $smarty->assign('Moderator',"1");
        break;
    case 1:
        $smarty->assign('Admin',"1");
        break;
    case 0:
        $smarty->assign('Lurker', "1");
        break;
}

if($tip_korisnika == 0){
    $smarty->display('naslovnica_neprijavljeni.tpl');
}else{
    $odjava = 1;
    $smarty->assign('odjava',$odjava);
    $smarty->display('naslovnica_prijavljeni.tpl');
}

$smarty->display('navigacija.tpl');

$smarty->display('podnozje.tpl');
