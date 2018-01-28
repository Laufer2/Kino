<?php
/* Smarty version 3.1.30, created on 2018-01-27 15:46:13
  from "C:\xampp\htdocs\kino\templates\filmovi.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6c90b56910c1_38907601',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '53b5e32f2bbb23466077ccc5eedb647ca1ccb591' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\filmovi.tpl',
      1 => 1517064371,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a6c90b56910c1_38907601 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="container">

    <form id='novi-film' method="post" action="src/filmovi/filmovi.php" enctype="application/x-www-form-urlencoded">

        <label for="film">Naziv filma</label>
        <input type="text" name="film" id="film" required><br/>

        <label for="godina">Godina</label>
        <input type="number" name="godina" id="godina" required><br/>

        <label for="trajanje">Trajanje</label>
        <input type="number" name="trajanje" id="trajanje" required><br/>

        <label for='sadrzaj'>Sadržaj</label>
        <textarea cols='20' rows='2' name='sadrzaj' id='sadrzaj' required></textarea><br/>

        <div id="zanr-filmovi"></div>

        <div id="redatelji">
            <label>Redatelj</label>
            <input type="text" name="redatelj[]" required><button type="button" id="novi-redatelj">+</button><br/>
        </div>

        <div id="glumci">
            <label>Glavni glumci</label>
            <input type="text" name="glumac[]" required><button type="button" id="novi-glumac">+</button><br/>
        </div>

        <div id="scenaristi">
            <label>Scenarist</label>
            <input type="text" name="scenarist[]" required><button type="button" id="novi-scenarist">+</button><br/>
        </div>

        <input type="submit" value="Kreiraj novi film">

    </form>

</div><?php }
}
