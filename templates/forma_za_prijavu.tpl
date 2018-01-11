<form method="post" id="prijava" name="prijava" action="prijava_validacija.php" enctype="application/x-www-form-urlencoded">

    <label for="username">Korisnicko ime: </label>
    <input type="text" id="korisnicko_ime" name="korisnicko_ime" required> <br/>
    <label for="password">Lozinka: </label>
    <input type="password" id="password" name="lozinka" required> <br />
    <input type="checkbox" id="zapamti_me" name="zapamti_me" value="1">

    <input type="submit" value="Login" name="login">

</form>