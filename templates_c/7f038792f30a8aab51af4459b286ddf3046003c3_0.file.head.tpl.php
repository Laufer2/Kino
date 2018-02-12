<?php
/* Smarty version 3.1.30, created on 2018-02-11 00:54:43
  from "C:\xampp\htdocs\kino\templates\head.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a7f8643a609d0_09673165',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f038792f30a8aab51af4459b286ddf3046003c3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\head.tpl',
      1 => 1518306879,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a7f8643a609d0_09673165 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<head>

    <title><?php echo (($tmp = @$_smarty_tpl->tpl_vars['Naslov_stranice']->value)===null||$tmp==='' ? "Kino" : $tmp);?>
</title>
    <meta charset="utf-8">
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"><?php echo '</script'; ?>
>

    <?php if (isset($_smarty_tpl->tpl_vars['privatno']->value)) {?>
        <link rel="stylesheet" href="../public/css/kino.css">
    <?php } else { ?>
        <link rel="stylesheet" href="public/css/kino.css">
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['statistika']->value) || isset($_smarty_tpl->tpl_vars['app_statistika']->value)) {?>
        <link rel="stylesheet" href="public/css/print-kino.css">
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['jquery_ui']->value)) {?>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"><?php echo '</script'; ?>
>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['registracija']->value)) {?>
        <?php echo '<script'; ?>
 src='https://www.google.com/recaptcha/api.js'><?php echo '</script'; ?>
>
    <?php }?>

</head>
<body>
<?php }
}
