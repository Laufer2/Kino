<div id="container">

    <div id="prikaz-forme">

        <div id="forma">
            <form method="post" action="src/registracija/registracija_obrada.php" id="registracija" enctype="application/x-www-form-urlencoded">

                <label for="ime">Ime</label><br/>
                <input type="text" name="ime" id="ime"> <br />

                <span id="ime_poruka" class="reg-poruka"></span> <br />

                <label for="prezime">Prezime</label><br/>
                <input type="text" name="prezime" id="prezime"> <br />

                <span id="prezime_poruka" class="reg-poruka"></span> <br />

                <label for="email">E-mail</label><br/>
                <input type="email" name="email" id="email"> <br />

                <span id="email_poruka" class="reg-poruka"></span> <br />

                <label for="korisnicko_ime">Korisničko ime</label><br/>
                <input type="text" name="korisnicko_ime" id="korisnicko_ime"> <br />

                <span id="korisnicko_ime_poruka" class="reg-poruka"></span> <br />

                <label for="lozinka">Lozinka</label><br/>
                <input type="password" name="lozinka" id="lozinka"><br />

                <span id="lozinka_poruka" class="reg-poruka"></span> <br />

                <label for="ponovo_lozinka">Ponovi lozinku</label><br/>
                <input type="password" name="ponovo_lozinka" id="ponovo_lozinka"> <br />

                <span id="ponovo_lozinka_poruka" class="reg-poruka"></span> <br />

                <div class="g-recaptcha" data-sitekey="6LejmEUUAAAAAFHa1CIqgvgmZcvmU8EiMhPIUdOL"></div><br/>

                <input type="submit" value="Registriraj se" id="submit" name="rega" ><br />

                <span id="greske"></span> <br />


            </form>
        </div>

    </div>


</div>