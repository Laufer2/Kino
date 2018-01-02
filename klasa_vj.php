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

$objekt = new auto();

$objekt->ispis();

$objekt->a = " sve";
echo $objekt->a;
