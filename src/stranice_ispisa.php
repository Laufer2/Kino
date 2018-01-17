<?php

function stranice_ispisa($redovi, $prikazi){

    // potrebna paginacija
    if($redovi > $prikazi){

        $stranice = $redovi / $prikazi;
        return ceil($stranice);

    }else{
        return 1;
    }
}