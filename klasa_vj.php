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

require_once 'datoteka.php';

$dat = new datoteka();
$vr = 0;
$dat->postavi("pomak", $vr);
$pomak = $dat->dohvati('pomak');

$a = time() + ($pomak*60*60);


echo "sada: " . time() . "<br/>";
echo "s pomakom: " .$a. "<br/> ";
echo "pomak u sekundama: ".$pomak*60*60 . "<br>";
echo "pomak u satima: ". $pomak;



