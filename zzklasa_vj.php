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


if($a !== false){
    echo "true";
}else{
    echo "false";
}




