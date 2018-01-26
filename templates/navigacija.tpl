<ul>
    <li>Naslovnica</li>
    {if isset($Lurker)}
        <li>Registracija</li>
        <li>Prijava</li>
    {/if}

    {if isset($Lurker) || isset($Korisnik) || isset($Moderator) || isset($Admin)}
        <li>O autoru</li>
        <li>Dokumentacija</li>
    {/if}

    {if isset($Korisnik) || isset($Moderator) || isset($Admin)}
        <li><a href="rezervacije.php">Rezervacije</a></li>
        <li>Slike</li>
        <li>Lokacije kina</li>
        <li id="odjava" style="cursor: pointer">Odjava</li>
    {/if}

    {if isset($Moderator) || isset($Admin)}
        <li>Filmovi</li>
        <li>Rezervacije</li>
        <li>Lokacije</li>
        <li>App statistika</li>
    {/if}

    {if isset($Admin)}
        <li>Postavke</li>
        <li>Dnevnik rada</li>
        <li>Statistika</li>
        <li>CRUD tablica</li>
    {/if}

</ul>