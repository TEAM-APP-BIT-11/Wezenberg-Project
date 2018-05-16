<?php


/**
 * Class Home
 * @class Home
 * @brief Controller-klasse voor Home van de trainer
 * @author Neil Van den Broeck
 *
 * Controller-klasse met alle methoden die gebruikt worden in de homepagina van de trainer
 */
class Home extends CI_Controller
{

    /**
     * Home constructor.
     * Indien de persoon die via deze controller gaat niet ingelogd is wordt deze doorgestuurd naar de log-in pagina.
     * Als de ingelogde persoon geen trainer is wordt deze doorgestuurd naar de login-pagina
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->authex->isAangemeld()) {
            redirect('Algemeen/logIn');
        } else {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->typePersoon->typePersoon != "trainer") {
                redirect('Algemeen/logIn');
            }
        }
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /**Geeft de homepagina van de trainer weer met de ongelezen meldingen via Melding_model in de view trainer/home.php
     * Geeft een lijst van objecten melding door naar de view.
     * @author Neil Van den Broeck
     * @see Melding_model::getAllFromPersoonAndNietGelezen()
     * @see trainer/home.php
     */
    public function index()
    {
        $data['titel'] = 'Home van de Trainer';
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";
        $persoon = $this->authex->getPersoonInfo();

        // moet variabele worden uit de sessie na het inloggen.

        $this->load->model('melding_model');
        $data['meldingen'] = $this->melding_model->getAllFromPersoonAndNietGelezen($persoon->id);

        $partials = array(
            'inhoud' => 'trainer/home',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**Geeft een pagina weer waarop de zwemmers staan. Hierop kan geklikt worden op hun agenda te openen.
     * Geeft een lijst van objecten persoon door naar de view.
     * @author Neil Van den Broeck
     * @see trainer/agenda.php
     */
    public function agenda()
    {
        $data['titel'] = 'Home van de Trainer';
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        $this->load->model("persoon_model");

        $data["zwemmers"] = $this->persoon_model->getZwemmers();

        $partials = array(
            'inhoud' => 'trainer/agenda',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
}
