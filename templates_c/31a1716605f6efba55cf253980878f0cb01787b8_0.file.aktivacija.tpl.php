<?php
/* Smarty version 3.1.30, created on 2018-01-09 22:39:09
  from "C:\xampp\htdocs\kino\templates\aktivacija.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a55367dd2f322_84167707',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '31a1716605f6efba55cf253980878f0cb01787b8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\aktivacija.tpl',
      1 => 1515533946,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a55367dd2f322_84167707 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if (isset($_smarty_tpl->tpl_vars['poruka']->value)) {?>

    <p><?php echo $_smarty_tpl->tpl_vars['poruka']->value;?>
</p>

<?php } elseif (isset($_smarty_tpl->tpl_vars['rok_istekao']->value)) {?>
    <p><?php echo $_smarty_tpl->tpl_vars['rok_istekao']->value;?>
</p>

    <form method="post" action="novi_akt_link.php" id="novi_link" enctype="application/x-www-form-urlencoded">
        <input type="email" id="email" name="email">
        <input type="submit" value="Pošalji aktivacijski kod">
        <span id="poruke"></span>
    </form>

<?php }
}
}
