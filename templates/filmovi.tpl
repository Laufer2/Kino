<div id="container">

    <div id="prikaz-forme">

        <div id="forma">

            <form id='novi-film' method="post" action="src/filmovi/filmovi.php" enctype="application/x-www-form-urlencoded">

                <label for="film">Naziv filma</label><br/>
                <input type="text" name="film" id="film" required><br/>

                <label for="godina">Godina</label><br/>
                <input type="number" name="godina" id="godina" required><br/>

                <label for="trajanje">Trajanje</label><br/>
                <input type="number" name="trajanje" id="trajanje" required><br/>

                <label for='sadrzaj'>Sadržaj</label><br/>
                <textarea cols='20' rows='2' name='sadrzaj' id='sadrzaj' required></textarea><br/>

                <div id="zanr-filmovi">
                    <label>Žanr&nbsp;</label><br/>
                </div>

                <div id="redatelji">
                    <label>Redatelj</label><br/>
                    <input type="text" name="redatelj[]" required><button type="button" class="gumb-plus" id="novi-redatelj">+</button><br/>
                </div>

                <div id="glumci">
                    <label>Glavni glumci</label><br/>
                    <input type="text" name="glumac[]" required><button type="button" class='gumb-plus' id="novi-glumac">+</button><br/>
                </div>

                <div id="scenaristi">
                    <label>Scenarist</label><br/>
                    <input type="text" name="scenarist[]" required><button type="button" class="gumb-plus" id="novi-scenarist">+</button><br/>
                </div>

                <input type="submit" value="Kreiraj novi film">

            </form>

        </div>

    </div>

    <div id="poruke">

    </div>

</div>