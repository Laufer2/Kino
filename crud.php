<?php
require_once '_header.php';

$varijabla = "";
$title = "CRUD";

$smarty->assign('jquery_ui',"da");
$smarty->assign('js_funkcije',"da");


if(!isset($_GET['tablica'])){
    $smarty->assign('Naslov_stranice', $title);
}else{
    $tablica = filter_input(INPUT_GET,'tablica');
    switch ($tablica){
        case "korisnik":
            $korisnik = "Korisnici";
            $smarty->assign('korisnik',$korisnik);
            $smarty->assign('Naslov_stranice', $korisnik);
            break;
        case "tipkorisnika":
            $tip_korisnika = "Tip korisnika";
            $smarty->assign('tip_korisnika', $tip_korisnika);
            $smarty->assign('Naslov_stranice',$tip_korisnika);
            break;
        case "lokacija":
            $lokacija = "Lokacije";
            $smarty->assign('lokacija', $lokacija);
            $smarty->assign('Naslov_stranice', $lokacija);
            break;

    }
}

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('crud.tpl');

$smarty->display('podnozje.tpl');