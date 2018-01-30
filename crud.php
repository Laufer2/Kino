<?php
require_once '_header.php';
require_once 'src/restrikcije.php';


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
    $smarty->assign('Naslov_stranice', "CRUD");
}else{
    $tablica = filter_input(INPUT_GET,'tablica');
    crud_tablica($smarty,$tablica);
}

$tip_korisnika = restrikcije($smarty);

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('navigacija.tpl');

if($tip_korisnika < 2){
    $smarty->display('crud.tpl');
}else{
    $smarty->display('zabrana.tpl');
}

$smarty->display('podnozje.tpl');