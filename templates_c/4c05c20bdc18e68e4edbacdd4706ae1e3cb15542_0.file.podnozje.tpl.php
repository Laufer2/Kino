<?php
/* Smarty version 3.1.30, created on 2018-01-05 21:07:16
  from "C:\xampp\htdocs\kino\templates\podnozje.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4fdaf45eb8d7_43515492',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c05c20bdc18e68e4edbacdd4706ae1e3cb15542' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\podnozje.tpl',
      1 => 1515182835,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4fdaf45eb8d7_43515492 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (isset($_smarty_tpl->tpl_vars['korisnicko']->value)) {?>
    <?php echo '<script'; ?>
 src="js/korisnicko_ime_ajax_provjera.js"><?php echo '</script'; ?>
>
<?php }?>

</body>
<?php }
}
