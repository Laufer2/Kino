<div id="container">

    <div id="iznad-tablice">

        <div id="tip-prikaza">
            <select id="tip">
                <option value="1" selected>Stranice</option>
                <option value="2">Upiti</option>
            </select>
        </div>

        <div id="vremenski_intervali">
            <select id="interval">
                <option value="1">Zadnji sat</option>
                <option value="24" selected>Zadnji dan</option>
                <option value="168">Zadnji tjedan</option>
                <option value="720">Zadnji mjesec</option>
                <option value="8760">Zadnja godina</option>
                <option value="580000">Od početka</option>
            </select>
        </div>

        <div id="search"></div>

        <div class="korisnik-statistika"></div>

        <div id="prikaz-tablice"></div>

        <div id="paginacija"></div>

        <div id="poruke"></div>

    </div>

    <div>
        <button class="print">Ispis</button>
    </div>

    <div id="grafovi">

        <div id="graf2">
        <canvas id="grafovi_statistika"></canvas>

        <div id="legenda"></div>

        </div>
    </div>

</div>