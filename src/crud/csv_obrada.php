<?php

require_once '../klase/baza.php';

if($_FILES['csv']){

    $tablica = filter_input(INPUT_POST,'tablica');
    $separator = filter_input(INPUT_POST,'separator');
    if($separator == ""){
        $separator = ",";
    }

    $db_stupac = "naziv_" . $tablica;
    $b = new baza();
    $baza = $b->spoji();
    $polje = array();
    $parametar="";
    $novi_redovi = $duplikati = 0;

    if(!$_FILES['csv']['error']){

        $dat = fopen($_FILES['csv']['tmp_name'], "r");

        $upit = $baza->prepare("INSERT INTO $tablica($db_stupac) VALUES (?)");

        while($linija = fgetcsv($dat,0,$separator)){

            foreach ($linija as $parametar){
                $upit->bind_param("s",$parametar);

                $upit2 = "SELECT * FROM $tablica WHERE $db_stupac = '$parametar'";
                $rez = $b->selectdb($upit2);
                if(!$rez->num_rows){
                    if($upit->execute()){
                        $novi_redovi++;
                    }
                }else{
                    $duplikati++;
                }
            }
        }
        $upit->close();
        $baza->close();

        echo json_encode(array("poruka" => "U tablicu je zapisano ".$novi_redovi." novih stavki. Broj neupisanih stavki(duplikati): ".$duplikati));

    }else{
        echo json_encode(array("poruka" => "Dogodila se greška. " . $_FILES['csv']['error']));
    }
}