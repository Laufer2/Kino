
<div id="container">

    <div id="tablicni-podaci">

        <div id="vremenski_intervali">
            <select id="interval">
                <option value="1">Zadnji sat</option>
                <option value="24">Zadnji dan</option>
                <option value="168">Zadnji tjedan</option>
                <option value="720">Zadnji mjesec</option>
                <option value="8760">Zadnja godina</option>
                <option value="580000" selected>Od početka</option>
            </select>
        </div>

        <div id="search"></div>

        <div id="prikaz-tablice"></div>

        <div id="paginacija"></div>

        <div id="poruke"></div>

    </div>
    <div>
        <button class="print">Ispis</button>
    </div>

    <div id="grafovi">


        <div id="graf1">

            <canvas id="udio_lajkova"></canvas>

            <canvas id="udio_nelajkova"></canvas>

            <div id="legenda"></div>

        </div>

    </div>

</div>