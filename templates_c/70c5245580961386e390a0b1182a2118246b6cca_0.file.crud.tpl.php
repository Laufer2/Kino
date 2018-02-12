<?php
/* Smarty version 3.1.30, created on 2018-02-12 13:14:36
  from "C:\xampp\htdocs\kino\templates\crud.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a81852c1b7a40_07087568',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '70c5245580961386e390a0b1182a2118246b6cca' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\crud.tpl',
      1 => 1518437672,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a81852c1b7a40_07087568 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="container">

    <div id="linkovi-tablice">
        <ul id="crud-linkovi">
            <li><a href="crud.php?tablica=korisnik">Korisnici</a></li>
            <li><a href="crud.php?tablica=tipkorisnika">Tip Korisnika</a></li>
            <li><a href="crud.php?tablica=lokacija">Lokacija</a></li>
            <li><a href="crud.php?tablica=drzava">Drzava</a></li>
            <li><a href="crud.php?tablica=grad">Grad</a></li>
            <li><a href="crud.php?tablica=zanr">Zanr</a></li>
            <li><a href="crud.php?tablica=osoba">Osoba</a></li>
            <li><a href="crud.php?tablica=tipuloga">Tip uloga</a></li>
            <li><a href="crud.php?tablica=tag">Oznaka</a></li>
            <li><a href="crud.php?tablica=stranica">Stranica</a></li>
            <li><a href="crud.php?tablica=korisnikstranica">Korisnik stranica</a></li>
            <li><a href="crud.php?tablica=upit">Upit</a></li>
            <li><a href="crud.php?tablica=korisnikupit">Korisnik upit</a></li>
            <li><a href="crud.php?tablica=adresa">Adresa</a></li>
            <li><a href="crud.php?tablica=film">Film</a></li>
            <li><a href="crud.php?tablica=projekcija">Projekcija</a></li>
            <li><a href="crud.php?tablica=moderatorlokacije">Moderatori lokacija</a></li>
            <li><a href="crud.php?tablica=zanrfilma">Zanr filma</a></li>
            <li><a href="crud.php?tablica=tagslika">Tag slike</a></li>
            <li><a href="crud.php?tablica=slika">Slike</a></li>
            <li><a href="crud.php?tablica=filmosoba">Film osobe</a></li>
            <li><a href="crud.php?tablica=rezervacija">Rezervacije</a></li>
            <li><a href="crud.php?tablica=lajkovi">Lajkovi</a></li>
        </ul>
    </div>

    <div id="iznad-tablice">

        <div id="search"></div>

        <div id="prikaz-tablice"></div>

    </div>

    <div id="paginacija"></div>

    <div id="prikaz-forme">
        <div id="forma"></div>
        <div id="test"></div>
    </div>

    <div class="dijalog-status-racuna" style="">
        <select id="meni-statusa" title="Status korisničkog računa">
            <option value='0'>Neaktiviran</option>
            <option value='1'>Aktiviran</option>
            <option value='2'>Zaključan</option>
        </select>
    </div>

    <div class="dijalog">
        <div id="dialog-potvrda" title="Obrisati red iz tablice?">
            <p>Zapis će se zauvijek izbrisati iz tablice. Jeste li sigurni?</p>
        </div>
    </div>

</div><?php }
}
