<html>
<head>

    <title>{$Naslov_stranice|default: "Kino"}</title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    {if isset($privatno)}
        <link rel="stylesheet" href="../public/css/kino.css">
    {else}
        <link rel="stylesheet" href="public/css/kino.css">
    {/if}
    {if isset($statistika) || isset($app_statistika)}
        <link rel="stylesheet" href="public/css/print-kino.css">
    {/if}

    {if isset($jquery_ui)}
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    {/if}

    {if isset($registracija)}
        <script src='https://www.google.com/recaptcha/api.js'></script>
    {/if}

</head>
<body>
