
{if isset($korisnicko)}
    <script src="public/js/registracija_validacija.js"></script>
{/if}

{if isset($privatno)}
    <script src="../public/js/korisnici.js"></script>
{/if}

{if isset($novi_aktivacijski_link)}
    <script src="public/js/novi_akt_link.js"></script>
{/if}

{if isset($prijava)}
    <script src="public/js/prijava.js"></script>
{/if}

{if isset($odjava)}
    <script src="public/js/odjava.js"></script>
{/if}

    <script src="public/js/funkcije.js"></script>

{if isset($katalog)}
    <script src="public/js/crud/katalog.js"></script>
{/if}

{if isset($adresa)}
    <script src="public/js/crud/adresa.js"></script>
{/if}

{if isset($film)}
    <script src="public/js/crud/film.js"></script>
{/if}

{if isset($projekcija)}
    <script src="public/js/crud/projekcija.js"></script>
{/if}

{if isset($korisnik)}
    <script src="public/js/crud/korisnik.js"></script>
{/if}

{if isset($konfiguracija)}
    <script src="public/js/konfiguracija.js"></script>
{/if}

{if isset($moderatorlokacije)}
    <script src="public/js/crud/moderatori_lokacija.js"></script>
{/if}

{if isset($zanrfilma)}
    <script src="public/js/crud/zanr_filma.js"></script>
{/if}

{if isset($tagslika)}
    <script src="public/js/crud/tag_slika.js"></script>
{/if}

{if isset($filmosoba)}
    <script src="public/js/crud/film_osoba.js"></script>
{/if}

{if isset($Lurker)}
    <script src="public/js/naslovnica.js"></script>
{/if}

{if isset($Korisnik)}
    <script src="public/js/naslovnica_prijavljeni.js"></script>
{/if}

{if isset($proj)}
    <script src="public/js/projekcije.js"></script>
{/if}

{if isset($rezervacija)}
    <script src="public/js/crud/rezervacija.js"></script>
{/if}

{if isset($rezervacije)}
    <script src="public/js/rezervacije_korisnik.js"></script>
{/if}

</body>