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
            $smarty->assign('katalozi', $tip_korisnika);
            $smarty->assign('Naslov_stranice',$tip_korisnika);
            break;
        case "lokacija":
            $tablica = "Lokacije";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;
        case "drzava":
            $tablica = "Države";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;
        case "grad":
            $tablica = "Gradovi";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;
        case "zanr":
            $tablica = "Žanrovi";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;
        case "osoba":
            $tablica = "Osobe";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;
        case "tipuloga":
            $tablica = "Tip uloga";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;
        case "tag":
            $tablica = "Oznake";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;
        case "stranica":
            $tablica = "Stranice";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;
        case "upit":
            $tablica = "upit";
            $smarty->assign('katalozi', $tablica);
            $smarty->assign('Naslov_stranice', $tablica);
            break;

    }
}

$smarty->display('head.tpl');

$smarty->display('zaglavlje.tpl');

$smarty->display('crud.tpl');

$smarty->display('podnozje.tpl');