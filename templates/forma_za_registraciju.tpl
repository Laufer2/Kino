<div id="container">

    <form method="post" action="src/registracija/registracija_obrada.php" id="registracija" enctype="application/x-www-form-urlencoded">

        <label for="ime">Ime: </label>
        <input type="text" name="ime" id="ime"> <br />

        <span id="ime_poruka" class="poruka"></span> <br />

        <label for="prezime">Prezime: </label>
        <input type="text" name="prezime" id="prezime"> <br />

        <span id="prezime_poruka" class="poruka"></span> <br />

        <label for="email">E-mail: </label>
        <input type="email" name="email" id="email"> <br />

        <span id="email_poruka" class="poruka"></span> <br />

        <label for="korisnicko_ime">Korisnicko ime: </label>
        <input type="text" name="korisnicko_ime" id="korisnicko_ime"> <br />

        <span id="korisnicko_ime_poruka" class="poruka"></span> <br />

        <label for="lozinka">Lozinka: </label>
        <input type="password" name="lozinka" id="lozinka"> <br />

        <span id="lozinka_poruka" class="poruka"></span> <br />

        <label for="ponovo_lozinka">Ponovi lozinku: </label>
        <input type="password" name="ponovo_lozinka" id="ponovo_lozinka"> <br />

        <span id="ponovo_lozinka_poruka" class="poruka"></span> <br />

        <input type="submit" value="Registriraj se" id="submit" name="rega" ><br />

        <span id="greske"></span> <br />

    </form>

</div>