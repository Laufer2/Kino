<?php

require_once 'datoteka.php';

$dat = new datoteka();


if(isset($_POST['akcija'])){

    $akcija = filter_input(INPUT_POST, 'akcija');

    switch ($akcija){

        case 0:
            $polje = array(
                "pomak" => $dat->dohvati('pomak'),
                "sesija" => $dat->dohvati('trajanje_sesije'),
                "prikazi" => $dat->dohvati('prikazi_po_stranici'),
                "rok" => $dat->dohvati('rok_trajanja_aktivacijskog_linka'),
                "prijave" => $dat->dohvati('neuspjesne_prijave')
            );
            echo json_encode($polje);
            break;


        case 1: // dohvaćanje pomaka s barka.foi.hr
            $pomak = $dat->dohvati_pomak();

            if($pomak !== false){
                $polje = array(
                    "poruka" => "Pomak uspješno dohvaćen. Iznosi " . $pomak,
                    "parametar" => $pomak,
                );

                echo json_encode($polje);

            }else{

                echo json_encode(array("poruka" => "Dohvaćanje pomaka nije uspjelo."));
            }
            break;

        case 2: // postavi parametar => zapiši ga u kino.ini

            $postavi = filter_input(INPUT_POST, 'postavi');
            $parametar = filter_input(INPUT_POST, 'parametar');
            $b = $dat->postavi($postavi, $parametar);

            if( $b !== false){

                $novi_parametar = $dat->dohvati($postavi);
                $polje = array(
                    "poruka" => "Postavljenje uspješno. Novi " . $postavi . " iznosi " . $novi_parametar,
                    "parametar" => $novi_parametar,
                );

                echo json_encode($polje);

            }else {

                echo json_encode(array("poruka" => "Postavljanje nije uspjelo."));
            }
    }
}
