<div id="container">

    <div id="prikaz-forme">

        <div id="forma">

            <form id='novi-termin' method="post" action="src/termini/termini.php" enctype="application/x-www-form-urlencoded">

                <div id="termini-lokacije"></div>

                <div id="termini-filmovi"></div>

                <fieldset>

                    <legend>Dostupan za rezervacije od</legend>
                    <label for="datum">Datum</label><br/>
                    <input type="date" name="datum1" id="datum" required><br>

                    <label for="sati">Vrijeme</label><br>
                    <input type="number" name="sati1" id="sati" placeholder="sati" max="23" required>

                    <input type="number" name="minute1" id="minute" placeholder="min" max="60" required><br/>

                </fieldset>

                <fieldset>

                    <legend>Dostupan za rezervacije do</legend>
                    <label for="datum">Datum</label><br>
                    <input type="date" name="datum2" id="datum" required><br>

                    <label for="sati">Vrijeme</label><br>
                    <input type="number" name="sati2" id="sati" placeholder="sati" min="0" max="23" required>

                    <input type="number" name="minute2" id="minute" placeholder="min" min="0" max="60" required><br/>

                </fieldset>

                <label for="mjesta">Maksimalan broj rezervacija</label>
                <input type="number" name="mjesta" id="mjesta" required><br/>

                <input type="submit" value="Kreiraj novi termin">

            </form>

            <div id="poruke"></div>

        </div>
    </div>
</div>

