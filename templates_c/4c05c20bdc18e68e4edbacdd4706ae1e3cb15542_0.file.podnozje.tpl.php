<?php
/* Smarty version 3.1.30, created on 2018-02-02 17:30:32
  from "C:\xampp\htdocs\kino\templates\podnozje.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a74922863ff11_93303656',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c05c20bdc18e68e4edbacdd4706ae1e3cb15542' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\podnozje.tpl',
      1 => 1517588760,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a74922863ff11_93303656 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="public/js/odjava.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="public/js/funkcije.js"><?php echo '</script'; ?>
>
<?php if (isset($_smarty_tpl->tpl_vars['naslovnica_prijavljeni']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/naslovnica_prijavljeni.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['Lurker']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/naslovnica.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['korisnicko']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/registracija_validacija.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['privatno']->value)) {?>
    <?php echo '<script'; ?>
 src="../public/js/korisnici.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['novi_aktivacijski_link']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/novi_akt_link.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['prijava']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/prijava.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['katalog']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/katalog.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['adresa']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/adresa.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['film']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/film.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['projekcija']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/projekcija.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['korisnik']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/korisnik.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['konfiguracija']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/konfiguracija.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['moderatorlokacije']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/moderatori_lokacija.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['zanrfilma']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/zanr_filma.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['tagslika']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/tag_slika.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['filmosoba']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/film_osoba.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['proj']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/projekcije.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['rezervacija']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/rezervacija.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['rezervacije']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/rezervacije.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['lokacije']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/lokacije.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['lajkovi']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/lajkovi.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['filmovi']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/filmovi.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['termini']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/termini.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['potvrde']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/potvrde.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['dnevnik']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/dnevnik.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['slike']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/slike.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['upload_slika']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/upload_slika.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['slika']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/crud/slika.js"><?php echo '</script'; ?>
>
<?php }
if (isset($_smarty_tpl->tpl_vars['app_statistika']->value)) {?>
    <?php echo '<script'; ?>
 src="public/js/app_statistika.js"><?php echo '</script'; ?>
>
<?php }?>

</body>
</html><?php }
}
