<?php
/* Smarty version 3.1.30, created on 2018-02-12 22:32:45
  from "C:\xampp\htdocs\kino\templates\projekcija.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a8207fd923457_31394407',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b110be669d523d98e6dba1823136a3d456af3663' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\projekcija.tpl',
      1 => 1518471163,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a8207fd923457_31394407 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="container">
    <div id="prikaz-forme">

        <div id="forma">
            <div id="detalji_filma">

                <div id="naziv_filma">
                    <span><b>Naziv filma:</b></span>

                </div>

                <div id="zanrovi">
                    <span><b>Žanr:</b></span>

                </div>

                <div id="trajanje">
                    <span><b>Trajanje:</b></span>
                </div>

                <div id="redatelj">
                    <span><b>Redatelj:</b></span>
                </div>

                <div id="scenarist">
                    <span><b>Scenarist:</b></span>
                </div>

                <div id="glumci">
                    <span><b>Glumci:</b></span>
                </div>

                <div id="sadrzaj">
                    <span><b>Opis:</b></span>
                </div>

            </div>
            <br/>
            <div id="detalji_rezervacija">

                <div id="lokacija">
                    <span><b>Lokacija:</b></span>
                </div>
                <div id="dostupan_od">
                    <span><b>Dostupan od:</b></span>
                </div>
                <div id="pocetak">
                    <span><b>Početak:</b></span>
                </div>

                <div id="ukupno_mjesta">
                    <span><b>Ukupno: </b></span>
                </div>
                <div id="dostupno_mjesta">
                    <span><b>Dostupno: </b></span>
                </div>
                <div>
                    <form method="post" id="rezerviranje" action="src/rezervacije/rezerviranje.php" enctype="application/x-www-form-urlencoded">
                        <input type="number" name="broj_rezervacija" id="broj_rezervacija">
                        <input type="submit" id="rezerviraj" value="Rezerviraj">
                    </form>
                </div>


            </div>

            <div id="poruke"></div>
        </div>
    </div>
</div><?php }
}
