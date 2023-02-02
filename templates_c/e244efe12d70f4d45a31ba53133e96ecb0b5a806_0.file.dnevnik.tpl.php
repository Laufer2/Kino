<?php
/* Smarty version 4.3.0, created on 2023-01-24 14:28:26
  from 'C:\xampp\htdocs\kino\templates\dnevnik.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63cfdcfa5e5f29_79497229',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e244efe12d70f4d45a31ba53133e96ecb0b5a806' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\dnevnik.tpl',
      1 => 1673623480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63cfdcfa5e5f29_79497229 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="container">

    <div id="iznad-tablice">

        <div id="tip-prikaza">
            <select id="tip">
                <option value="10" selected>Sve</option>
                <option value="1">Radnje</option>
                <option value="2">Upiti</option>
                <option value="3">Stranice</option>
            </select>
        </div>

        <div id="vremenski_intervali">
            <select id="interval">
                <option value="1">Zadnji sat</option>
                <option value="24" selected>Zadnji dan</option>
                <option value="168">Zadnji tjedan</option>
                <option value="720">Zadnji mjesec</option>
                <option value="8760">Zadnja godina</option>
                <option value="580000">Od početka</option>
            </select>
        </div>

        <div id="search"></div>

        <div id="prikaz-tablice"></div>

        <div id="paginacija"></div>
        <div id="poruke"></div>
    </div>

    <div style="display: none;">
        <div id="dialog-potvrda" title="Obrisati red iz tablice?">
            <p>Zapis će se zauvijek izbrisati iz tablice. Jeste li sigurni?</p>
        </div>
    </div>

</div><?php }
}
