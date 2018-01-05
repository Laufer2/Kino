<?php
/* Smarty version 3.1.30, created on 2018-01-05 14:56:26
  from "C:\xampp\htdocs\kino\templates\forma_za_prijavu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4f840ac70161_65847208',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3fe741776069cd3feaffa058980ccab743907c9c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\forma_za_prijavu.tpl',
      1 => 1514972782,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4f840ac70161_65847208 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form method="post" id="prijava" name="prijava" action="prijava_validacija.php" enctype="application/x-www-form-urlencoded">

    <label for="username">Korisnicko ime: </label>
    <input type="text" id="username" name="korisnicko_ime" required> <br/>
    <label for="password">Lozinka: </label>
    <input type="password" id="password" name="lozinka" required> <br />

    <input type="submit" value="Login" name="login">

</form><?php }
}
