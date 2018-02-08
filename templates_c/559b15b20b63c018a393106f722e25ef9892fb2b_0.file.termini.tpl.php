<?php
/* Smarty version 3.1.30, created on 2018-02-08 19:20:40
  from "C:\xampp\htdocs\kino\templates\termini.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a7c94f8460398_05156772',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '559b15b20b63c018a393106f722e25ef9892fb2b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\termini.tpl',
      1 => 1518113998,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a7c94f8460398_05156772 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="container">

    <div id="prikaz-forme">

        <div id="forma">

            <form id='novi-termin' method="post" action="src/termini/termini.php" enctype="application/x-www-form-urlencoded">

                <div id="termini-lokacije"></div>

                <div id="termini-filmovi"></div>

                <fieldset>

                    <legend>Dostupan za rezervacije od</legend>
                    <label for="datum">Datum</label><br/>
                    <input type="date" name="datum1" id="datum" required><br>

                    <label for="sati">Vrijeme</label><br>
                    <input type="number" name="sati1" id="sati" placeholder="sati" max="23" required>

                    <input type="number" name="minute1" id="minute" placeholder="min" max="60" required><br/>

                </fieldset>

                <fieldset>

                    <legend>Dostupan za rezervacije do</legend>
                    <label for="datum">Datum</label><br>
                    <input type="date" name="datum2" id="datum" required><br>

                    <label for="sati">Vrijeme</label><br>
                    <input type="number" name="sati2" id="sati" placeholder="sati" min="0" max="23" required>

                    <input type="number" name="minute2" id="minute" placeholder="min" min="0" max="60" required><br/>

                </fieldset>

                <label for="mjesta">Maksimalan broj rezervacija</label>
                <input type="number" name="mjesta" id="mjesta" required><br/>

                <input type="submit" value="Kreiraj novi termin">

            </form>

            <div id="poruke"></div>

        </div>
    </div>
</div>

<?php }
}
