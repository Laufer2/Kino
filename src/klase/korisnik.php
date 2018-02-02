<?php

class korisnik
{
    private $id_korisnik;
    private $tip_id;
    private $ime;
    private $prezime;
    private $email;
    private $korisnicko_ime;
    private $prijavljen_od;

    public function set_podaci($id_korisnika, $tip_id, $ime, $prezime, $email, $korisnicko_ime, $prijavljen_do){
        $this->id_korisnik = $id_korisnika;
        $this->tip_id = $tip_id;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->email = $email;
        $this->korisnicko_ime = $korisnicko_ime;
        $this->prijavljen_od = $prijavljen_do;

    }


    public function getKorisnickoIme()
    {
        return $this->korisnicko_ime;
    }

    public function getIdKorisnik()
    {
        return $this->id_korisnik;
    }

    public function getTipId()
    {
        return $this->tip_id;
    }

    public function getPrijavljenOd()
    {
        return $this->prijavljen_od;
    }
}
