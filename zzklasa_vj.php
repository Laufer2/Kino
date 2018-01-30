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

$uri = $_SERVER["REQUEST_URI"];
$pos = strrpos($uri, "/");
$skripta = substr($uri, $pos+1);

session_start();
setcookie(session_name(), '', -3600);
session_unset();
session_destroy();
$_SESSION = array();



