<?php
/* Smarty version 3.1.30, created on 2018-01-10 14:00:55
  from "C:\xampp\htdocs\kino\templates\forma_za_registraciju.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a560e8788e891_18802109',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e94c12e677128ef8c86df762f105b847785cf116' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\forma_za_registraciju.tpl',
      1 => 1515587549,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a560e8788e891_18802109 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form method="post" action="registracija_obrada.php" id="registracija" enctype="application/x-www-form-urlencoded">


    <label for="ime">Ime: </label>
    <input type="text" name="ime" id="ime"> <br />

    <span id="ime_poruka" class="poruka"></span> <br />

    <label for="prezime">Prezime: </label>
    <input type="text" name="prezime" id="prezime"> <br />

    <span id="prezime_poruka" class="poruka"></span> <br />

    <label for="email">E-mail: </label>
    <input type="email" name="email" id="email"> <br />

    <span id="email_poruka" class="poruka"></span> <br />

    <label for="korisnicko_ime">Korisnicko ime: </label>
    <input type="text" name="korisnicko_ime" id="korisnicko_ime"> <br />

    <span id="korisnicko_ime_poruka" class="poruka"></span> <br />

    <label for="lozinka">Lozinka: </label>
    <input type="password" name="lozinka" id="lozinka"> <br />

    <span id="lozinka_poruka" class="poruka"></span> <br />

    <label for="ponovo_lozinka">Ponovi lozinku: </label>
    <input type="password" name="ponovo_lozinka" id="ponovo_lozinka"> <br />

    <span id="ponovo_lozinka_poruka" class="poruka"></span> <br />

    <input type="submit" value="Registriraj se" id="submit" name="rega" ><br>

    <span id="greske"></span><br>

</form><?php }
}
