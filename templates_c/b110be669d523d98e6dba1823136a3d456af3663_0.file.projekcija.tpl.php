<?php
/* Smarty version 3.1.30, created on 2018-01-25 18:55:55
  from "C:\xampp\htdocs\kino\templates\projekcija.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6a1a2b2803b1_75736032',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b110be669d523d98e6dba1823136a3d456af3663' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\projekcija.tpl',
      1 => 1516902953,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a6a1a2b2803b1_75736032 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="container">

    <div id="detalji_filma">

        <div id="naziv_filma">

        </div>

        <div id="zanrovi">

        </div>

        <div id="trajanje">

        </div>

        <div id="redatelj">

        </div>

        <div id="scenarist">

        </div>

        <div id="glumci">

        </div>

        <div id="sadrzaj">

        </div>

    </div>
    <br/>
    <div id="detalji_rezervacija">

        <div id="lokacija"></div>
        <div id="pocetak"></div>
        <div id="dostupan_od"></div>
        <span>Ukupno: </span><div id="ukupno_mjesta"></div>
        <span>Dostupn: </span><div id="dostupno_mjesta"></div>
        <div>
            <form method="post" id="rezerviranje" action="src/rezervacije/rezerviranje.php" enctype="application/x-www-form-urlencoded">
                <input type="number" name="broj_rezervacija" id="broj_rezervacija">
                <input type="submit" id="rezerviraj" value="Rezerviraj">
            </form>
        </div>


    </div>

    <div id="poruke"></div>


</div><?php }
}
