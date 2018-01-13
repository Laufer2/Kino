<?php
/* Smarty version 3.1.30, created on 2018-01-13 01:50:25
  from "C:\xampp\htdocs\kino\templates\navigacija.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a5957d140cd18_87988540',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c71c513d6fd9d9a16c26b21bcd315327f94f85c7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\navigacija.tpl',
      1 => 1515804624,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5957d140cd18_87988540 (Smarty_Internal_Template $_smarty_tpl) {
?>
<ul>
    <li>Naslovnica</li>
    <?php if (isset($_smarty_tpl->tpl_vars['Lurker']->value)) {?>
        <li>Registracija</li>
        <li>Prijava</li>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['Lurker']->value) || isset($_smarty_tpl->tpl_vars['Korisnik']->value) || isset($_smarty_tpl->tpl_vars['Moderator']->value) || isset($_smarty_tpl->tpl_vars['Admin']->value)) {?>
        <li>O autoru</li>
        <li>Dokumentacija</li>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['Korisnik']->value) || isset($_smarty_tpl->tpl_vars['Moderator']->value) || isset($_smarty_tpl->tpl_vars['Admin']->value)) {?>
        <li>Rezervacije</li>
        <li>Slike</li>
        <li>Lokacije kina</li>
        <li id="odjava" style="cursor: pointer">Odjava</li>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['Moderator']->value) || isset($_smarty_tpl->tpl_vars['Admin']->value)) {?>
        <li>Filmovi</li>
        <li>Rezervacije</li>
        <li>Lokacije</li>
        <li>App statistika</li>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['Admin']->value)) {?>
        <li>Postavke</li>
        <li>Dnevnik rada</li>
        <li>Statistika</li>
        <li>CRUD tablica</li>
    <?php }?>

</ul><?php }
}
