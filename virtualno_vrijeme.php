<?php

/*Agregacija - Dependency injection
  class virtualno_vrijeme koristi class datoteka*/

class virtualno_vrijeme
{
    private $dat;

    function __construct(datoteka $datoteka)
    {
        $this->dat = $datoteka;
    }

    //čitanje pomaka iz datoteke kino.ini
    function dohvati()
    {
        $pomak = $this->dat->dohvati("pomak");
        return $pomak;

    }

    //dohvaćanje pomaka sa stranice i zapisivanje u datoteku kino.ini
    function postavi()
    {
        $json = file_get_contents('http://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=json');
        $polje = json_decode($json, true);
        $novi_pomak = 0;

        foreach ($polje as $webdip => $vrijednosti){
            foreach ($vrijednosti as $vrijeme => $pomak){
                foreach ($pomak as $broj_sati => $vrijednost){
                    foreach ($vrijednost as $item => $value){
                        $novi_pomak = $value;
                    }
                }
            }
        }
        $this->dat->postavi('pomak',$novi_pomak);
    }
}