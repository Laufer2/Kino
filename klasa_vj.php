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

$email = 'ivan@localhost.com';
$naslov = 'Testni mail';
$poruka = 'Poruka';
$headers = 'From: webmaster@kino.org';

if(mail($email, $naslov, $poruka, $headers)){
    echo "Poslano.";
}else{
    echo "nije poslano";
}



