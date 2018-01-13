<?php
/* Smarty version 3.1.30, created on 2018-01-12 19:44:58
  from "C:\xampp\htdocs\kino\templates\forma_za_prijavu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a59022aa2ffe7_63214744',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3fe741776069cd3feaffa058980ccab743907c9c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\forma_za_prijavu.tpl',
      1 => 1515782657,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a59022aa2ffe7_63214744 (Smarty_Internal_Template $_smarty_tpl) {
?>

<form method="post" id="prijava" name="prijava" action="src/prijava/prijava_obrada.php" enctype="application/x-www-form-urlencoded">

    <label for="username">Korisnicko ime: </label>
    <input type="text" id="korisnicko_ime" name="korisnicko_ime" value="" required> <br/>
    <label for="password">Lozinka: </label>
    <input type="password" id="password" name="lozinka" required> <br />
    <input type="checkbox" id="zapamti_me" name="zapamti_me" value="1" checked>

    <input type="submit" value="Login" name="login">


</form>
<span id="greske"></span>

<div  id="zaboravljena-lozinka" style="cursor: pointer">
    <p>Zaboravljena lozinka?</p>
</div>

<form method="post" id="nova_lozinka" action="src/prijava/zaboravljena_lozinka.php" enctype="application/x-www-form-urlencoded">
    <input type="email" id="email" name="email">
    <input type="submit" value="Pošalji novu lozinku">

</form>
<span id="poruke"></span>
<?php }
}
