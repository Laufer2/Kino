<div id="container">

    <div id="iznad-tablice">

        <div id="tip-prikaza">
            <select id="tip">
                <option value="10" selected>Sve</option>
                <option value="1">Radnje</option>
                <option value="2">Upiti</option>
                <option value="3">Stranice</option>
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

        <div id="prikaz-tablice"></div>

        <div id="paginacija"></div>
        <div id="poruke"></div>
    </div>

    <div style="display: none;">
        <div id="dialog-potvrda" title="Obrisati red iz tablice?">
            <p>Zapis će se zauvijek izbrisati iz tablice. Jeste li sigurni?</p>
        </div>
    </div>

</div>