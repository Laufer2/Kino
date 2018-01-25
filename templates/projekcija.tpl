<div id="container">

    <div id="detalji_filma">

        <div id="naziv_filma">

        </div>

        <div id="zanrovi">

        </div>

        <div id="trajanje">

        </div>

        <div id="redatelj">

        </div>

        <div id="scenarist">

        </div>

        <div id="glumci">

        </div>

        <div id="sadrzaj">

        </div>

    </div>
    <br/>
    <div id="detalji_rezervacija">

        <div id="lokacija"></div>
        <div id="pocetak"></div>
        <div id="dostupan_od"></div>
        <span>Ukupno: </span><div id="ukupno_mjesta"></div>
        <span>Dostupn: </span><div id="dostupno_mjesta"></div>
        <div>
            <form method="post" id="rezerviranje" action="src/rezervacije/rezerviranje.php" enctype="application/x-www-form-urlencoded">
                <input type="number" name="broj_rezervacija" id="broj_rezervacija">
                <input type="submit" value="Rezerviraj">
            </form>
        </div>


    </div>

    <div id="poruke"></div>


</div>