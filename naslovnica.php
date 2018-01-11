<?php
require_once 'korisnik.php';

session_start();
echo "Ovo je naslovnica. Dobrodošli ";
$a = $_SESSION['kino']->get_kor_ime();

echo $a;
