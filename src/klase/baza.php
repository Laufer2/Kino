<?php

class baza{

    const server = "localhost";
    const username = "laufer";
    const password = "administrator1";
    const dbime = "kino";


    function spoji(){
        $mysqli = new mysqli( self::server, self::username, self::password, self::dbime);

        if ($mysqli->connect_errno) {
            echo "Pogreška prilikom spajanja na bazu:".$mysqli->connect_errno.", ".mysqli_connect_error();
        }

        $mysqli->set_charset("utf8");

        return $mysqli;

    }

    function prekini($veza){
        $veza->close();
    }

    function selectdb($upit){
        $veza = self::spoji();

        $rezultat = $veza->query($upit);

        if(!$rezultat){
            $rezultat = null;
            return $rezultat;
        }

        self::prekini($veza);
        return $rezultat;
    }

    function update($upit){
        $veza = self::spoji();

        $rezultat = $veza->query($upit);

        if($rezultat){
            self::prekini($veza);
            return $rezultat;
        }else{
            self::prekini($veza);
            return $rezultat;
        }
    }
}