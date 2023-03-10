<?php
/* Smarty version 4.3.0, created on 2023-01-24 14:27:56
  from 'C:\xampp\htdocs\kino\templates\filmovi.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63cfdcdc1ae299_29441321',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '53b5e32f2bbb23466077ccc5eedb647ca1ccb591' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\filmovi.tpl',
      1 => 1673623480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63cfdcdc1ae299_29441321 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="container">

    <div id="prikaz-forme">

        <div id="forma">

            <form id='novi-film' method="post" action="src/filmovi/filmovi.php" enctype="application/x-www-form-urlencoded">

                <label for="film">Naziv filma</label><br/>
                <input type="text" name="film" id="film" required><br/>

                <label for="godina">Godina</label><br/>
                <input type="number" name="godina" id="godina" required><br/>

                <label for="trajanje">Trajanje</label><br/>
                <input type="number" name="trajanje" id="trajanje" required><br/>

                <label for='sadrzaj'>Sadržaj</label><br/>
                <textarea cols='20' rows='2' name='sadrzaj' id='sadrzaj' required></textarea><br/>

                <div id="zanr-filmovi">
                    <label>Žanr&nbsp;</label><br/>
                </div>

                <div id="redatelji">
                    <label>Redatelj</label><br/>
                    <input type="text" name="redatelj[]" required><button type="button" class="gumb-plus" id="novi-redatelj">+</button><br/>
                </div>

                <div id="glumci">
                    <label>Glavni glumci</label><br/>
                    <input type="text" name="glumac[]" required><button type="button" class='gumb-plus' id="novi-glumac">+</button><br/>
                </div>

                <div id="scenaristi">
                    <label>Scenarist</label><br/>
                    <input type="text" name="scenarist[]" required><button type="button" class="gumb-plus" id="novi-scenarist">+</button><br/>
                </div>

                <input type="submit" value="Kreiraj novi film">

            </form>

        </div>

    </div>

    <div id="poruke"></div>

</div><?php }
}
