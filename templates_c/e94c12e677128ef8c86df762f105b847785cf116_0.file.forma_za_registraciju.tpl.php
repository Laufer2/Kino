<?php
/* Smarty version 3.1.30, created on 2018-01-05 22:01:15
  from "C:\xampp\htdocs\kino\templates\forma_za_registraciju.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4fe79be2a1a3_20738864',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e94c12e677128ef8c86df762f105b847785cf116' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\forma_za_registraciju.tpl',
      1 => 1515185791,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4fe79be2a1a3_20738864 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form method="post" id="registracija" action="registracija_obrada.php" enctype="application/x-www-form-urlencoded">

    <!--<label for="ime">Ime: &malt; </label>
    <input type="text" name="ime"> <br />

    <label for="prezime">Prezime: </label>
    <input type="text" name="prezime"> <br />

    <label for="email">E-mail: </label>
    <input type="email" name="email"> <br />-->

    <label for="korisnicko_ime">Korisnicko ime: </label>
    <input type="text" name="korisnicko_ime" id="korime"> <br />

    <span id="korime_poruka"></span> <br />

    <label for="lozinka">Lozinka: </label>
    <input type="password" name="lozinka"> <br />

    <label for="ponovo_lozinka">Ponovi lozinku: </label>
    <input type="password" name="ponovo_lozinka"> <br />

    <input type="submit" value="Registriraj se" name="rega">

</form><?php }
}
