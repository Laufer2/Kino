<?php
/* Smarty version 3.1.30, created on 2018-01-11 19:09:22
  from "C:\xampp\htdocs\kino\templates\forma_za_prijavu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a57a852b14305_69947607',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3fe741776069cd3feaffa058980ccab743907c9c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\forma_za_prijavu.tpl',
      1 => 1515694126,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a57a852b14305_69947607 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form method="post" id="prijava" name="prijava" action="prijava.php" enctype="application/x-www-form-urlencoded">

    <label for="username">Korisnicko ime: </label>
    <input type="text" id="korisnicko_ime" name="korisnicko_ime" value="" required> <br/>
    <label for="password">Lozinka: </label>
    <input type="password" id="password" name="lozinka" required> <br />
    <input type="checkbox" id="zapamti_me" name="zapamti_me" value="1" checked>

    <input type="submit" value="Login" name="login">


</form>
<span id="greske"></span><?php }
}
