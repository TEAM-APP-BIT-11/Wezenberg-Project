<?php

/**
 * Home controller met alle methoden die gebruikt worden op de homepagina voor de zwemmer
 * @class Home
 * @brief Controller voor de Homepagina van de zwemmer
 * @author Neil Van den Broeck
 */
class Home extends CI_Controller
{
    /**
     * Home constructor.
     * Constructor die controleerd of de persoon is ingelogd. zo niet wordt deze doorgestuurd naar de loginpagina
     * Indien de persoon geen zwemmer is wordt deze doorgestuurd naar de login-pagina.
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->authex->isAangemeld()) {
            redirect('Welcome/logIn');
        } else {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->typePersoon->typePersoon !== "zwemmer") {
                redirect('Welcome/logIn');
            }
        }

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /**Geeft de homepagina van de zwemmer weer met de ongelezen meldingen via Melding_model in de view zwemmer/home.php
     * Geeft een lijst van objecten melding door naar de view.
     * @author Neil Van den Broeck
     * @see \Melding_model::getAllFromPersoonAndNietGelezen()
     * @see zwemmer/home.php
     */
    public function index()
    {
        $data['titel'] = 'Home van de Zwemmer';
        $persoon = $this->authex->getPersoonInfo();
        $data['persoon'] = $persoon;
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";


        $this->load->model('melding_model');
        $data['meldingen'] = $this->melding_model->getAllFromPersoonAndNietGelezen($persoon->id);

        $partials = array(
            'inhoud' => 'zwemmer/home',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
}
