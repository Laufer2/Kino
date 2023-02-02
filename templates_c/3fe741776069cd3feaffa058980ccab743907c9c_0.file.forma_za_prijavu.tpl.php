<?php
/* Smarty version 4.3.0, created on 2023-01-24 13:55:31
  from 'C:\xampp\htdocs\kino\templates\forma_za_prijavu.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63cfd5430bacf3_91407595',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3fe741776069cd3feaffa058980ccab743907c9c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\forma_za_prijavu.tpl',
      1 => 1673623480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63cfd5430bacf3_91407595 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="container">
    <div id="prikaz-forme">

        <div id="forma">

            <form method="post" id="prijava" name="prijava" action="src/prijava/prijava_obrada.php" enctype="application/x-www-form-urlencoded">

                <label for="username">Korisničko ime: </label><br/>
                <input type="text" id="korisnicko_ime" name="korisnicko_ime" value="" required> <br/>
                <label for="password">Lozinka: </label><br/>
                <input type="password" id="password" name="lozinka" required> <br />
                <label for="password">Zapamti me&nbsp;</label>
                <input type="checkbox" id="zapamti_me" name="zapamti_me" value="1" checked><br/>

                <input type="submit" value="Prijavi se" name="login">


            </form>
            <span id="greske"></span>

            <div  id="zaboravljena-lozinka">
                <p>Zaboravljena lozinka?</p>
            </div>

            <form method="post" id="nova_lozinka" action="src/prijava/zaboravljena_lozinka.php" enctype="application/x-www-form-urlencoded">
                <input type="email" id="email" name="email" placeholder="e-mail">
                <input type="submit" value="Pošalji novu lozinku">

            </form>

            <span id="poruke"></span>

        </div>
    </div>
</div>
<?php }
}
