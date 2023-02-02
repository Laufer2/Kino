<?php
/* Smarty version 4.3.0, created on 2023-01-24 14:27:50
  from 'C:\xampp\htdocs\kino\templates\slike.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63cfdcd6ba3db2_77798348',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1e4b5a6cdba4af3044d9c4d88792f499709fbe5c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\slike.tpl',
      1 => 1673623480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63cfdcd6ba3db2_77798348 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="container">

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
