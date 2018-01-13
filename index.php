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
        $korisnik = 1;
        $smarty->assign('Korisnik',$korisnik);
        break;
    case 2:
        $moderator = 1;
        $smarty->assign('Moderator',$moderator);
        break;
    case 1:
        $admin = 1;
        $smarty->assign('Admin',$admin);
        break;
    case 0:
        $lurker = 1;
        $smarty->assign('Lurker', $lurker);
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
