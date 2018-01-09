
{if isset($poruka)}

    <p>{$poruka}</p>

{elseif isset($rok_istekao)}
    <p>{$rok_istekao}</p>

    <form method="post" action="novi_akt_link.php" id="novi_link" enctype="application/x-www-form-urlencoded">
        <input type="email" id="email" name="email">
        <input type="submit" value="Pošalji aktivacijski kod">
        <span id="poruke"></span>
    </form>

{/if}
