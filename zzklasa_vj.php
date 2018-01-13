<?php

class auto{

     public $a = "unutra";
     public static $b = "bbb";

     private function postavi(){
          $this->a="eee";
     }

     function ispis(){
         $this->postavi();
         echo $this->a;
     }
}

require_once 'src/klase/datoteka.php';
$dat = new datoteka();
$vr = 0;
$ak = 2;
$dat->postavi("pomak", $vr);
$dat->postavi("rok_trajanja_aktivacijskog_linka", $ak);
$pomak = $dat->dohvati('pomak');

$a = time() + ($pomak*60*60);

$f = 'ivan@localhost.com';

echo "sada: " . time() . "<br/>";
echo "s pomakom: " .$a. "<br/> ";
echo "pomak u sekundama: ".$pomak*60*60 . "<br>";
echo "pomak u satima: ". $pomak;
session_start();
$tip_korisnika = $_SESSION['kino']->getIdKorisnik;

echo $tip_korisnika;


