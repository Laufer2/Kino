<?php
/* Smarty version 3.1.30, created on 2018-01-30 17:42:36
  from "C:\xampp\htdocs\kino\templates\navigacija.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a70a07c916f64_36634172',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c71c513d6fd9d9a16c26b21bcd315327f94f85c7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\navigacija.tpl',
      1 => 1517330546,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a70a07c916f64_36634172 (Smarty_Internal_Template $_smarty_tpl) {
?>
<ul>
    <li><a href="index.php">Naslovnica</a></li>
    <?php if (isset($_smarty_tpl->tpl_vars['Lurker']->value)) {?>
        <li><a href="registracija.php">Registracija</a></li>
        <li><a href="prijava.php">Prijava</a></li>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['Lurker']->value) || isset($_smarty_tpl->tpl_vars['Korisnik']->value) || isset($_smarty_tpl->tpl_vars['Moderator']->value) || isset($_smarty_tpl->tpl_vars['Admin']->value)) {?>
        <li><a href="o_autoru.html">O autoru</a></li>
        <li><a href="dokumentacija.html">Dokumentacija</a></li>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['Korisnik']->value) || isset($_smarty_tpl->tpl_vars['Moderator']->value) || isset($_smarty_tpl->tpl_vars['Admin']->value)) {?>
        <li><a href="rezervacije.php">Rezervacije</a></li>
        <li><a href="slike.php">Slike</a></li>
        <li><a href="lokacije.php">Lokacije kina</a></li>
        <li id="odjava" style="cursor: pointer">Odjava</li>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['Moderator']->value) || isset($_smarty_tpl->tpl_vars['Admin']->value)) {?>
        <li><a href="filmovi.php">Filmovi</a></li>
        <li><a href="potvrde.php">Potvrde rezervacija</a></li>
        <li><a href="termini.php">Termini</a></li>
        <li><a href="app_statistika.php">Aplikativna statistika</a></li>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['Admin']->value)) {?>
        <li><a href="konfiguracija.php">Postavke</a></li>
        <li><a href="dnevnik.php">Dnevnik</a></li>
        <li><a href="statistika.php">Statistika</a></li>
        <li><a href="crud.php">CRUD</a></li>
    <?php }?>

</ul><?php }
}
