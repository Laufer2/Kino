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
require_once 'virtualno_vrijeme.php';

$dat = new datoteka();
$vv = new virtualno_vrijeme($dat);

echo time();
echo time() + ($dat->dohvati('rok_trajanja_aktivacijskog_koda')*60*60);
/*
if($dat->dohvati('trajanje_sesije') !== false){
    echo $dat->dohvati('trajanje_sesije');
}else{
    echo "nien";
}

*/
if($vv->dohvati() !== false){
    echo $vv->dohvati();
}else{
    echo "WWW";
}

/*
if($vv->postavi() !== false){
    echo "dobro";
}else{
    echo "nije dobro";
}
*/



