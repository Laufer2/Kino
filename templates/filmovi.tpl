<div id="container">

    <form id='novi-film' method="post" action="src/filmovi/filmovi.php" enctype="application/x-www-form-urlencoded">

        <label for="film">Naziv filma</label>
        <input type="text" name="film" id="film" required><br/>

        <label for="godina">Godina</label>
        <input type="number" name="godina" id="godina" required><br/>

        <label for="trajanje">Trajanje</label>
        <input type="number" name="trajanje" id="trajanje" required><br/>

        <label for='sadrzaj'>Sadržaj</label>
        <textarea cols='20' rows='2' name='sadrzaj' id='sadrzaj' required></textarea><br/>

        <div id="zanr-filmovi"></div>

        <div id="redatelji">
            <label>Redatelj</label>
            <input type="text" name="redatelj[]" required><button type="button" id="novi-redatelj">+</button><br/>
        </div>

        <div id="glumci">
            <label>Glavni glumci</label>
            <input type="text" name="glumac[]" required><button type="button" id="novi-glumac">+</button><br/>
        </div>

        <div id="scenaristi">
            <label>Scenarist</label>
            <input type="text" name="scenarist[]" required><button type="button" id="novi-scenarist">+</button><br/>
        </div>

        <input type="submit" value="Kreiraj novi film">

    </form>

    <div id="poruke">

    </div>

</div>