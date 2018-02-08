<div id="container">
    <div id="prikaz-forme">

        <div id="forma">

            <form method="post" id="prijava" name="prijava" action="src/prijava/prijava_obrada.php" enctype="application/x-www-form-urlencoded">

                <label for="username">Korisnicko ime: </label><br/>
                <input type="text" id="korisnicko_ime" name="korisnicko_ime" value="" required> <br/>
                <label for="password">Lozinka: </label><br/>
                <input type="password" id="password" name="lozinka" required> <br />
                <label for="password">Zapamti me&nbsp;</label>
                <input type="checkbox" id="zapamti_me" name="zapamti_me" value="1" checked><br/>

                <input type="submit" value="Prijavi se" name="login">


            </form>
            <span id="greske"></span>

            <div  id="zaboravljena-lozinka">
                <p>Zaboravljena lozinka?</p>
            </div>

            <form method="post" id="nova_lozinka" action="src/prijava/zaboravljena_lozinka.php" enctype="application/x-www-form-urlencoded">
                <input type="email" id="email" name="email" placeholder="e-mail">
                <input type="submit" value="Pošalji novu lozinku">

            </form>

            <span id="poruke"></span>

        </div>
    </div>
</div>
