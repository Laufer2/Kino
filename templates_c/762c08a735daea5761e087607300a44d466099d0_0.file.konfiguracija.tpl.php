<?php
/* Smarty version 4.3.0, created on 2023-01-24 14:28:20
  from 'C:\xampp\htdocs\kino\templates\konfiguracija.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63cfdcf49be3d4_72978099',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '762c08a735daea5761e087607300a44d466099d0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\konfiguracija.tpl',
      1 => 1673623480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63cfdcf49be3d4_72978099 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="container">
    <div id="prikaz-forme">
        <div id="forma">

            <div id="p">
                <button id="dohvati-pomak">Dohvati pomak vremena s barka.foi.hr</button>
                <form method="post" action="src/konfiguracija.php" id="postavi_pomak" enctype="application/x-www-form-urlencoded">
                    <label>Vremenski pomak(h) </label>
                    <input type="number" id="pomak" title="Vremenski pomak">
                    <input type="submit" value="Postavi"><br/>
                </form>
            </div>

            <div id="s">
                <form method="post" action="src/konfiguracija.php" id="postavi_sesiju" enctype="application/x-www-form-urlencoded">
                    <label>Trajanje sesije(min) </label>
                    <input type="number" id="sesija" title="Vrijeme trajanja korisničke sesije u minutama">
                    <input type="submit" value="Postavi"><br/>
                </form>

            </div>

            <div id="pr">
                <form method="post" action="src/konfiguracija.php" id="postavi_prikaze" enctype="application/x-www-form-urlencoded">
                    <label>Broj prikaza po stranici </label>
                    <input type="number" id="prikazi" title="Maksimalan broj prikaza zapisa po tablici bez paginacije">
                    <input type="submit" value="Postavi"><br/>
                </form>

            </div>

            <div id="akt-rok">
                <form method="post" action="src/konfiguracija.php" id="postavi_rok" enctype="application/x-www-form-urlencoded">
                    <label>Rok aktivacije računa(h) </label>
                    <input type="number" id="rok" title="Rok linka za aktivaciju korisničkog računa">
                    <input type="submit" value="Postavi"><br/>
                </form>

            </div>

            <div id="pri">
                <form method="post" action="src/konfiguracija.php" id="postavi_prijave" enctype="application/x-www-form-urlencoded">
                    <label>Uzastopne neuspješne prijave</label>
                    <input type="number" id="prijave">
                    <input type="submit" value="Postavi"><br/>
                </form>

            </div>

            <div id="poruke">

            </div>
        </div>
    </div>
</div><?php }
}
