<?php
/* Smarty version 3.1.30, created on 2018-01-19 14:32:28
  from "C:\xampp\htdocs\kino\templates\podnozje.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a61f36c7dc3d2_47096841',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c05c20bdc18e68e4edbacdd4706ae1e3cb15542' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\podnozje.tpl',
      1 => 1516367636,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a61f36c7dc3d2_47096841 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (isset($_smarty_tpl->tpl_vars['korisnicko']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/registracija_validacija.js"><?php echo '</script'; ?>
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

<?php if (isset($_smarty_tpl->tpl_vars['katal']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/katalog.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['adresa']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/adresa.js"><?php echo '</script'; ?>
>
<?php }?>



</body>
<?php }
}
