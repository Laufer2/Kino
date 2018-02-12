<?php
/* Smarty version 3.1.30, created on 2018-02-11 13:30:21
  from "C:\xampp\htdocs\kino\templates\statistika.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a80375d544fe8_77501273',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5277f270141554076a156620b05d224bc37b3429' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\statistika.tpl',
      1 => 1518352205,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a80375d544fe8_77501273 (Smarty_Internal_Template $_smarty_tpl) {
?>
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

    <form method="post" action="src/statistike/statistika.php" id="gen_pdf" enctype="application/x-www-form-urlencoded">
        <input type="submit" value="PDF">
    </form>

    <div>
        <button class="print">Ispis</button>
    </div>

    <div id="grafovi">

        <div id="graf2">
        <canvas id="grafovi_statistika"></canvas>

        <div id="legenda"></div>

        </div>
    </div>

</div><?php }
}
