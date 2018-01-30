<?php
/* Smarty version 3.1.30, created on 2018-01-28 21:46:06
  from "C:\xampp\htdocs\kino\templates\termini.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a6e368ede2ba3_30841043',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '559b15b20b63c018a393106f722e25ef9892fb2b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\termini.tpl',
      1 => 1517172364,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a6e368ede2ba3_30841043 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="container">

    <div id="container">

        <form id='novi-termin' method="post" action="src/termini/termini.php" enctype="application/x-www-form-urlencoded">

            <div id="termini-lokacije"></div>

            <div id="termini-filmovi"></div>

            <fieldset>

                <legend>Dostupan od</legend>
                <label for="datum">Datum</label>
                <input type="date" name="datum1" id="datum" required>

                <label for="sati">Vrijeme</label>
                <input type="number" name="sati1" id="sati" placeholder="sati" required><span> : </span>

                <input type="number" name="minute1" id="minute" placeholder="min" required><br/>

            </fieldset>

            <fieldset>

                <legend>Dostupan do</legend>
                <label for="datum">Datum</label>
                <input type="date" name="datum2" id="datum" required>

                <label for="sati">Vrijeme</label>
                <input type="number" name="sati2" id="sati" placeholder="sati" required><span> : </span>

                <input type="number" name="minute2" id="minute" placeholder="min" required><br/>

            </fieldset>

            <label for="mjesta">Broj rezervacija</label>
            <input type="number" name="mjesta" id="mjesta" required><br/>

            <input type="submit" value="Kreiraj novi film">

        </form>

        <div id="poruke">

        </div>

    </div>


</div>

<?php }
}
