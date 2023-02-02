<?php
/* Smarty version 4.3.0, created on 2023-01-24 13:55:37
  from 'C:\xampp\htdocs\kino\templates\dokumentacija.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63cfd549434235_64607029',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a834de03a97e1e7952b2276970f7883568c31e5b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\kino\\templates\\dokumentacija.tpl',
      1 => 1673623480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63cfd549434235_64607029 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="container">

    <section>
        <h2>Kratak opis projekta</h2>
        <div>
            Aplikacija kino služi za kreiranje i rezervaciju projekcija podijeljenih prema kategorijama projekcija<br/>
            <h4>Uloge:</h4>
            <ul>
                <li>Neregistrirani korisnik</li>
                <li> Registrirani korisnik</li>
                <li> Moderator sajma</li>
                <li>Administrator</li>
            </ul>
            <h4>Neregistrirani korisnik</h4>
            <section>
                <p>
                    Neregistriran korisnik je korisnik koji nije prijavljen u sustav. Ovaj korisnik ima mogućnost prijave u sustav, kreiranja
                    korisničkog računa, pregled dokumentacije i stranice <i>O autoru</i> te mu je dostupan pregled prve tri projekcije s odabrane
                    lokacije koje počinju nakon trenutnog vremena.
                </p>
            </section>
            <h4>Registrirani korisnik</h4>
            <section>
                <p>
                    Registriran korisnik je korisnik koji je kreirao i aktivirao svoj korisnički račun te se sa podacima za prijavu prijavio
                    u sustav. Ovom korisniku je na naslovnici dostupan odabir svih lokacija te odabirom lokacije može vidjeti sadašnje ili
                    ili buduće projekcije koje se održavaju na toj lokaciji. Odabirom projekcije korisnik vidi detalje o toj projekciji,
                    vidi broj slobodnih mjesta, ako ima mjesta ili je projekcija datumski dostupna može napraviti rezervaciju za tu projekciju.
                    Isti korisnik može rezervirati više mjesta za isti termin projekcije.
                    Na stranici <i>Rezervacije</i> može pregledavati svoje potvrđene i ne potvrđene rezervacije.
                    Na stranici lokacije kina, može vidjeti popis svih lokacija kina koje imaju adresu te također kliknuti na gumb
                    <i>sviđa mi se</i> ili <i>ne sviđa mi se</i>. Također vidi ukupan broj klikova na <i>sviđa mi se</i> i <i>ne sviđa mi se</i>
                    za svaku lokaciju.
                    Na kraju mu je dostupna mogućnost odjave sa sustava.

                </p>
            </section>
            <h4>Moderator sustava</h4>
            <section>
                <p>
                    Moderator sustava je korisnik kojem je administrator sustava dodjelio status povlaštenog korisnika te s tim statusom
                    je dobio dodatne funkcije za upravljanje nad sustavom.
                    Na stranici <i>Filmovi</i> može kreirati novi film kojem će onda na stranici <i>Termini</i> dodati termin projekcije
                    za lokacija koju moderira. Svaki termin ima vrijeme i datum kad je on dostupan i ima ograničen broj korisnika
                    koji smije pristupiti. Filmu kojem je dodijeljen termin bit će dostupan korisniku na pregled i rezerviranje
                    mjesta na naslovnici sustava.
                    Na stranici <i>Potvrde rezervacija</i> može potvrditi ili odbiti rezervacije korisnika za projekcije po lokacijama
                    koje moderator moderira.
                    Stranica <i>Aplikativna statistika</i> moderatoru nudi pregled klikova po lokacijama koje može filtrirati po vremenskom
                    periodu
                </p>
            </section>
            <h4>Administrator sustava</h4>
            <section>
                <p>
                    Administrator sustava je korisnik koji ima sva prava kao prethodno navedeni korisnici. Uz to, na stranici <i>Postavke</i>
                    može postaviti određene parametre sustava kao što su pomak vremena, trajanje sesije, broj prikaza po stranici u tablicama,
                    rok aktivacije računa te ukupni broj uzastopnih neuspješnih prijava korisnika nakon kojih će se zaključati korisnikov račun.
                    Na stranici <i>Dnevnik</i> administrator može pregledavati i pretraživati zahtjeve, radnje, stranice i upite koje su korisnici
                    izvršavali te ih filtrirati po vremenskom intervalu. Na stranici <i>Statistika</i> administrator vidi posjećenost određenih
                    stranica i statistiku za određene upite nad bazom podataka koji se koriste u aplikaciji. Statistiku posjećenosti može
                    filtrirati po korisnicima i vremenskom periodu te sortirati po datumu i vremenu.
                    CRUD je administratorski dio sustava preko kojeg može pregledavati, kreirati, brisati i ažurirati podatke iz svih tablica
                    koje postoje u bazi podataka. Tu također definira lokacije kina, dodaje adrese za iste te dodjeljuje moderatore lokaciji.
                    Preko csv datoteke može popuniti ili ažurirati tablice koje predstavljaju katalog.
                </p>
            </section>


        </div>
    </section>
    <section >
        <h2>Era model</h2>
        <a href="slike/era.png" target="_blank">
            <img class="dijagrami" src="slike/era.png" alt="Era dijagram">
        </a>
    </section>
    <section >
        <h2>Dijagrami</h2>
        <h2>Neregistrirani korisnik</h2>
        <a href="slike/neregistrirani.png" target="_blank">
            <img class="dijagrami" src="slike/neregistrirani.png" alt="Neregistrirani korisnik">
        </a>
    </section>
    <section>
        <h2>Registrirani korisnik</h2>
        <a href="slike/registrirani.png" target="_blank">
            <img class="dijagrami" src="slike/registrirani.png" alt="Registrirani">
        </a>
    </section>
    <section >
        <h2>Moderator</h2>
        <a href="slike/moderator.png" target="_blank">
            <img class="dijagrami" src="slike/moderator.png" alt="Moderator">
        </a>
    </section>
    <section >
        <h2>Administrator</h2>
        <a href="slike/administrator.png" target="_blank">
            <img class="dijagrami" src="slike/administrator.png" alt="Administrator">
        </a>
    </section>


    <section>
        <h2>Korišteni alati</h2>
        <ol>
            <li>Phpstorm - okruženje za pisanje i testiranje koda</li>
            <li>Apache - web server za izvršavanje php skripti</li>
            <li>Mercury - e-mail server za testiranje funkcionalnosti vezanih za e-mail poruke</li>
            <li>MySQL - baza podataka za dugoročno spremanje podataka bitnih za sustav</li>
            <li>Draw.io - kreiranje mape sustava i navigacijskog dijagrama</li>
            <li>MySQL Benchmark - kreiranje modela podataka</li>
        </ol>
    </section>


    </section>




</div><?php }
}
