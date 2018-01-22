<?php
require_once '_header.php';

$varijabla = "";
$title = "CRUD";

$smarty->assign('jquery_ui',"da");
$smarty->assign('js_funkcije',"da");


function crud_tablica($smarty, $tablica){
    if($tablica == 'lokacija' || $tablica == "tipkorisnika"
        || $tablica == 'zanr' || $tablica == "osoba"
        || $tablica == "drzava" || $tablica == "grad"
        || $tablica == "tipuloga" || $tablica == "tag"
        || $tablica == "stranica" || $tablica == "upit"){
        $smarty->assign('katalog', 'da');
    }else{
        $smarty->assign($tablica, $tablica);
    }

    $smarty->assign('Naslov_stranice', $tablica);
}

if(!isset($_GET['tablica'])){
    $smarty->assign('Naslov_stranice', $title);
}else{
    $tablica = filter_input(INPUT_GET,'tablica');
    crud_tablica($smarty,$tablica);
    //$smarty->assign('katalog',$tablica);
}

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('crud.tpl');

$smarty->display('podnozje.tpl');