<?php
/* Smarty version 3.1.30, created on 2018-01-23 13:45:08
  from "C:\xampp\htdocs\kino\templates\podnozje.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a672e5426e241_40249737',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c05c20bdc18e68e4edbacdd4706ae1e3cb15542' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\podnozje.tpl',
      1 => 1516711508,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a672e5426e241_40249737 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (isset($_smarty_tpl->tpl_vars['korisnicko']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/registracija_validacija.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['privatno']->value)) {?>
    <?php echo '<script'; ?>
 src="../public/js/korisnici.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['novi_aktivacijski_link']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/novi_akt_link.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['prijava']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/prijava.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['odjava']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/odjava.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['js_funkcije']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/funkcije.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['katalog']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/katalog.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['adresa']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/adresa.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['film']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/film.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['projekcija']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/projekcija.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['korisnik']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/korisnik.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['konfiguracija']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/konfiguracija.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['moderatorlokacije']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/moderatori_lokacija.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['zanrfilma']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/zanr_filma.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['tagslika']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/tag_slika.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['filmosoba']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/film_osoba.js"><?php echo '</script'; ?>
>
<?php }?>


</body>
<?php }
}
