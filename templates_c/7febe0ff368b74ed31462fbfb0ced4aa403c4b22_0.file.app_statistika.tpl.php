<?php
/* Smarty version 3.1.30, created on 2018-02-11 13:53:36
  from "C:\xampp\htdocs\kino\templates\app_statistika.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a803cd08138f8_82129535',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7febe0ff368b74ed31462fbfb0ced4aa403c4b22' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\app_statistika.tpl',
      1 => 1518353613,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a803cd08138f8_82129535 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="container">

    <div id="tablicni-podaci">

        <div id="vremenski_intervali">
            <select id="interval">
                <option value="1">Zadnji sat</option>
                <option value="24">Zadnji dan</option>
                <option value="168">Zadnji tjedan</option>
                <option value="720">Zadnji mjesec</option>
                <option value="8760">Zadnja godina</option>
                <option value="580000" selected>Od početka</option>
            </select>
        </div>

        <div id="search"></div>

        <div id="prikaz-tablice"></div>

        <div id="paginacija"></div>

        <div id="poruke"></div>

    </div>
    <div>
        <button class="print">Ispis</button>
    </div>

    <div id="grafovi">


        <div id="graf1">

            <canvas id="udio_lajkova"></canvas>

            <canvas id="udio_nelajkova"></canvas>

            <div id="legenda"></div>

        </div>

    </div>

</div><?php }
}
