<?php
/* Smarty version 3.1.30, created on 2018-02-10 17:53:09
  from "C:\xampp\htdocs\kino\templates\forma_za_registraciju.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a7f237587f610_63934649',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e94c12e677128ef8c86df762f105b847785cf116' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\forma_za_registraciju.tpl',
      1 => 1518280799,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a7f237587f610_63934649 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="container">

    <div id="prikaz-forme">

        <div id="forma">
            <form method="post" action="src/registracija/registracija_obrada.php" id="registracija" enctype="application/x-www-form-urlencoded">

                <label for="ime">Ime</label><br/>
                <input type="text" name="ime" id="ime"> <br />

                <span id="ime_poruka" class="reg-poruka"></span> <br />

                <label for="prezime">Prezime</label><br/>
                <input type="text" name="prezime" id="prezime"> <br />

                <span id="prezime_poruka" class="reg-poruka"></span> <br />

                <label for="email">E-mail</label><br/>
                <input type="email" name="email" id="email"> <br />

                <span id="email_poruka" class="reg-poruka"></span> <br />

                <label for="korisnicko_ime">Korisničko ime</label><br/>
                <input type="text" name="korisnicko_ime" id="korisnicko_ime"> <br />

                <span id="korisnicko_ime_poruka" class="reg-poruka"></span> <br />

                <label for="lozinka">Lozinka</label><br/>
                <input type="password" name="lozinka" id="lozinka"><br />

                <span id="lozinka_poruka" class="reg-poruka"></span> <br />

                <label for="ponovo_lozinka">Ponovi lozinku</label><br/>
                <input type="password" name="ponovo_lozinka" id="ponovo_lozinka"> <br />

                <span id="ponovo_lozinka_poruka" class="reg-poruka"></span> <br />

                <div class="g-recaptcha" data-sitekey="6LejmEUUAAAAAFHa1CIqgvgmZcvmU8EiMhPIUdOL"></div><br/>

                <input type="submit" value="Registriraj se" id="submit" name="rega" ><br />

                <span id="greske"></span> <br />


            </form>
        </div>

    </div>


</div><?php }
}
