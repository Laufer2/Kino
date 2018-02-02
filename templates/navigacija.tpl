<ul>
    <li><a href="index.php">Naslovnica</a></li>
    {if isset($Lurker)}
        <li><a href="registracija.php">Registracija</a></li>
        <li><a href="prijava.php">Prijava</a></li>
    {/if}

    {if isset($Lurker) || isset($Korisnik) || isset($Moderator) || isset($Admin)}
        <li><a href="o_autoru.html">O autoru</a></li>
        <li><a href="dokumentacija.html">Dokumentacija</a></li>
    {/if}

    {if isset($Korisnik) || isset($Moderator) || isset($Admin)}
        <li><a href="rezervacije.php">Rezervacije</a></li>
        <li><a href="slike.php">Slike</a></li>
        <li><a href="lokacije.php">Lokacije kina</a></li>
        <li><a href="upload_slika.php">Upload slika</a></li>
        <li id="odjava" style="cursor: pointer">Odjava</li>
    {/if}

    {if isset($Moderator) || isset($Admin)}
        <li><a href="filmovi.php">Filmovi</a></li>
        <li><a href="potvrde.php">Potvrde rezervacija</a></li>
        <li><a href="termini.php">Termini</a></li>
        <li><a href="app_statistika.php">Aplikativna statistika</a></li>
    {/if}

    {if isset($Admin)}
        <li><a href="konfiguracija.php">Postavke</a></li>
        <li><a href="dnevnik.php">Dnevnik</a></li>
        <li><a href="statistika.php">Statistika</a></li>
        <li><a href="crud.php">CRUD</a></li>
    {/if}

</ul>