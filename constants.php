<?php 

define('siteName', "VolontirajDonesi - Budi human sugrađanin");

$errorMessages = array(
    "sveobavezno" => "Sva polja su obavezna",
    "telformat" => "Broj telefona nije u ispravnom formatu",
    "mailformat" => "Email adresa nije u ispravnom formatu",
    "postojiuser" => "Već postoji korisnik sa istim brojem telefona/email adresom",
    "kratkalozinka" => "Lozinka je kraća od 8 karaktera",
    "lozinkanejednaka" => "Lozinke se ne poklapaju",
    "netacnalozinka" => "Lozinka je netačna",
    "uslovi" => "Molimo prihvatite uslove korišćenja",
    "nepostojecikorisnik" => "Nepostojeći korisnik, registrujte se!",
    "dbgreska" => "Greška u uspostavljanju veze sa bazom",
    "nemaadrese" => "Nije uneta adresa ili lokacija za dostavu"
);

function getErrorMessages() {
    global $errorMessages;
    return $errorMessages;
}

$successMessages = array(
    "registracija" => "Registracija uspešna, ulogujte se",
    "logovanje" => "Logovanje uspešno, možete pristupiti svim sadržajima sada",
    "dodato" => "Uspešno dodat zahtev za pomoć",
);

function getSuccessMessages() {
    global $successMessages;
    return $successMessages;
}

function siteURL()
{
    $protocol = 'https://';
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}
define( 'SITE_URL', siteURL() );