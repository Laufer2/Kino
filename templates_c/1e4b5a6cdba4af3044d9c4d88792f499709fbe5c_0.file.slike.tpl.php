<?php
/* Smarty version 3.1.30, created on 2018-02-12 16:10:16
  from "C:\xampp\htdocs\kino\templates\slike.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a81ae5829b933_10074336',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1e4b5a6cdba4af3044d9c4d88792f499709fbe5c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\slike.tpl',
      1 => 1518448212,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a81ae5829b933_10074336 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="container">

    <div id="iznad-tablice">
        <div id="search">
            <form method='post' action='src/slike/pregled_slika.php' id='pretraga' enctype='application/x-www-form-urlencoded'>
                <input type='text' name='pojam' id='pojam' placeholder="oznaka">
                <input type='submit' value='P'>
            </form>
        </div>
    </div>

    <div class="lista-slika">

    </div>

    <div id="test"></div>

</div><?php }
}
