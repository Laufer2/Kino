<?php
/* Smarty version 3.1.30, created on 2018-01-05 15:05:48
  from "C:\xampp\htdocs\kino\templates\head.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a4f863c65db92_91131920',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f038792f30a8aab51af4459b286ddf3046003c3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\head.tpl',
      1 => 1515161147,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a4f863c65db92_91131920 (Smarty_Internal_Template $_smarty_tpl) {
?>
<head>
    <title><?php echo (($tmp = @$_smarty_tpl->tpl_vars['Naslov_stranice']->value)===null||$tmp==='' ? "Kino" : $tmp);?>
</title>
    <meta charset="utf-8">
    <meta name="author" content="Boris Maduna">
    <?php if (isset($_smarty_tpl->tpl_vars['jquery']->value)) {?>
        <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"><?php echo '</script'; ?>
>
    <?php }?>
</head>
<body>
<?php }
}