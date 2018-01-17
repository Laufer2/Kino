<?php
require_once '../klase/baza.php';

if(filter_input(INPUT_SERVER,'REQUEST_METHOD')== 'GET'){

    $tablica = filter_input(INPUT_GET,'tablica');

    $upit = "SELECT * FROM lokacija l JOIN adresa a ON l.id_lokacija = a.lokacija_id 
            JOIN drzava d ON a.drzava_id = d.id_drzava JOIN grad g ON a.grad_id = g.id_grad";
    $baza = new baza();
    $lokacije = array();
    $lokacije['podaci']=array();

    if($rezultat = $baza->selectdb($upit)){

        while ($polje = $rezultat->fetch_array(MYSQLI_ASSOC)){
            extract($polje);

            $red = array(
                "id_lokacija" => $id_lokacija,
                "naziv_lokacije" => $naziv_lokacije,
                "ulica" => $ulica,
                "broj" => $broj,
                "naziv_grada" => $naziv_grada,
                "naziv_drzave" => $naziv_drzave
            );

            array_push($lokacije['podaci'], $red);
        };

        echo json_encode($lokacije);

    }else{
        echo "Ne mogu dohvatiti traženu tablicu.";
    }


}