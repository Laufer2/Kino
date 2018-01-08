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

        if ($polje = parse_ini_file($this->ime_datoteke)) {
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

}