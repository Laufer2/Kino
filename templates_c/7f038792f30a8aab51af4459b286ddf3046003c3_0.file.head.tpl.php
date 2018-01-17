<?php
/* Smarty version 3.1.30, created on 2018-01-16 19:36:55
  from "C:\xampp\htdocs\kino\templates\head.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a5e4646f12b03_90991220',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f038792f30a8aab51af4459b286ddf3046003c3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\head.tpl',
      1 => 1516125284,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5e4646f12b03_90991220 (Smarty_Internal_Template $_smarty_tpl) {
?>
<head>
    <title><?php echo (($tmp = @$_smarty_tpl->tpl_vars['Naslov_stranice']->value)===null||$tmp==='' ? "Kino" : $tmp);?>
</title>
    <meta charset="utf-8">
    <meta name="author" content="Boris Maduna">
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"><?php echo '</script'; ?>
>
    <?php if (isset($_smarty_tpl->tpl_vars['jquery_ui']->value)) {?>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"><?php echo '</script'; ?>
>
    <?php }?>

</head>
<body>
<?php }
}
