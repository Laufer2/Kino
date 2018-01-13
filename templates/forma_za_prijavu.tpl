
<form method="post" id="prijava" name="prijava" action="src/prijava/prijava_obrada.php" enctype="application/x-www-form-urlencoded">

    <label for="username">Korisnicko ime: </label>
    <input type="text" id="korisnicko_ime" name="korisnicko_ime" value="" required> <br/>
    <label for="password">Lozinka: </label>
    <input type="password" id="password" name="lozinka" required> <br />
    <input type="checkbox" id="zapamti_me" name="zapamti_me" value="1" checked>

    <input type="submit" value="Login" name="login">


</form>
<span id="greske"></span>

<div  id="zaboravljena-lozinka" style="cursor: pointer">
    <p>Zaboravljena lozinka?</p>
</div>

<form method="post" id="nova_lozinka" action="src/prijava/zaboravljena_lozinka.php" enctype="application/x-www-form-urlencoded">
    <input type="email" id="email" name="email">
    <input type="submit" value="Pošalji novu lozinku">

</form>
<span id="poruke"></span>
