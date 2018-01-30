<div id="container">

    <div id="container">

        <form id='novi-termin' method="post" action="src/termini/termini.php" enctype="application/x-www-form-urlencoded">

            <div id="termini-lokacije"></div>

            <div id="termini-filmovi"></div>

            <fieldset>

                <legend>Dostupan od</legend>
                <label for="datum">Datum</label>
                <input type="date" name="datum1" id="datum" required>

                <label for="sati">Vrijeme</label>
                <input type="number" name="sati1" id="sati" placeholder="sati" required><span> : </span>

                <input type="number" name="minute1" id="minute" placeholder="min" required><br/>

            </fieldset>

            <fieldset>

                <legend>Dostupan do</legend>
                <label for="datum">Datum</label>
                <input type="date" name="datum2" id="datum" required>

                <label for="sati">Vrijeme</label>
                <input type="number" name="sati2" id="sati" placeholder="sati" required><span> : </span>

                <input type="number" name="minute2" id="minute" placeholder="min" required><br/>

            </fieldset>

            <label for="mjesta">Broj rezervacija</label>
            <input type="number" name="mjesta" id="mjesta" required><br/>

            <input type="submit" value="Kreiraj novi film">

        </form>

        <div id="poruke">

        </div>

    </div>


</div>

