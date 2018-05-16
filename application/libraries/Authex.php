<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex
{

    /**
     * Authex constructor.
     */
    public function __construct()
    {
        $CI = &get_instance();

        $CI->load->model('persoon_model');
    }

    /**
     * @param $id
     */
    function activeer($id)
    {
        // nieuwe gebruiker activeren
        $CI = &get_instance();

        $CI->gebruiker_model->activeer($id);
    }

    /**
     * Geeft de persoon terug die is aangemeld. Indien geen aanmelding -> Null;
     * @return $persoon Het object persoon die is aangemeld
     */
    function getPersoonInfo()
    {
        // geef gebruiker-object als gebruiker aangemeld is
        $CI = &get_instance();

        if (!$this->isAangemeld()) {
            return null;
        } else {
            $persoon = $CI->session->userdata('gebruiker');
            return $persoon;
        }
    }

    /**
     * Controleerd of de gebruiker is aangemeld (= sessiondata)
     * @return bool waarde of de gebruiker is aangemeld(true) of false(niet aangemeld)
     */
    function isAangemeld()
    {
        // gebruiker is aangemeld als sessievariabele gebruiker_id bestaat
        $CI = &get_instance();

        if ($CI->session->has_userdata('gebruiker_id')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Meld de gebruiker aan indien deze een correcte gebruikersnaam en wachtwoordcombinatie invuld.
     * Controleerd of de gebruiker en het wachtwoord in de database overeenkomen en meld deze dan aan (return = true).
     * Indien deze wachtwoord + gebruikersnaam combinatie niet in database terechtkomt wordt de gebruiker niet aangemeld en returned de functie false;
     * @param $gebruikersnaam gebruikersnaam van de persoon die wil aanmelden
     * @param $wachtwoord ingevoerde wachtwoord van de persoon die wil aanmelden.
     * @return bool waarde of het aanmelden is geslaagd.
     */
    function meldAan($gebruikersnaam, $wachtwoord)
    {
        // gebruiker aanmelden met opgegeven email en wachtwoord
        $CI = &get_instance();

        $gebruiker = $CI->persoon_model->getPersoonWithType($gebruikersnaam, $wachtwoord);

        if ($gebruiker == null) {
            return false;
        } else {
            $CI->session->set_userdata('gebruiker_id', $gebruiker->id);
            $CI->session->set_userdata('gebruiker', $gebruiker);
            return true;
        }
    }

    /**
     * Meld de gebruiker af door de session variabelen die aangemaakt worden bij het aanmelden te verwijderen.
     */
    function meldAf()
    {
        // afmelden, dus sessievariabele wegdoen
        $CI = &get_instance();

        $CI->session->unset_userdata('gebruiker_id');
        $CI->session->unset_userdata('gebruiker');
    }

    /**
     * Voegt een nieuwe gebruiker toe aan de database indien het e-mailadres nog niet bestaat.
     * @param $naam naam van de gebruiker
     * @param $email email van de toegevoegde persoon
     * @param $wachtwoord wachtwoord van de toegevoegde persoon
     * @return int id van de toegevoegde persoon
     */
    function registreer($naam, $email, $wachtwoord)
    {
        // nieuwe gebruiker registreren als email nog niet bestaat
        $CI = &get_instance();

        if ($CI->gebruiker_model->controleerEmailVrij($email)) {
            $id = $CI->gebruiker_model->voegToe($naam, $email, $wachtwoord);
            return $id;
        } else {
            return 0;
        }
    }


}
