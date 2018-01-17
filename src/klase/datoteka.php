<?php


class datoteka{

    private $ime_datoteke = 'kino.ini';

    function dohvati ($parametar){

        if ($polje = parse_ini_file($this->ime_datoteke)) {

            foreach ($polje as $kljuc => $vrijednost) {
                if ($parametar == $kljuc) {
                    return $vrijednost;
                }
            }
        }else{
            return false;
        }
    }

    function postavi ($parametar, $nova_vrijednost){

        if ($polje = @parse_ini_file($this->ime_datoteke)) {
            $novi_zapis = '';
            $datoteka = fopen($this->ime_datoteke,"w");

            foreach ($polje as $kljuc => $vrijednost){
                if($kljuc == $parametar){
                    $polje[$kljuc] = $nova_vrijednost;
                    $novi_zapis .= $kljuc. "=". $nova_vrijednost ."\n";
                }else{
                    $novi_zapis .= $kljuc. "=". $vrijednost ."\n";
                }
            }

            $zapisivanje = fwrite($datoteka, $novi_zapis);
            fclose($datoteka);

            return $zapisivanje;

        }else{
            return false;
        }
    }

    //dohvaćanje pomaka sa stranice i zapisivanje u datoteku kino.ini
    function dohvati_pomak()
    {
        if($json = @file_get_contents('http://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=json'))
        {
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
            $this->postavi('pomak',$novi_pomak);
        }
        else
        {
            return false;
        }
    }

}