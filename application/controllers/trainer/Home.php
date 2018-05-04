<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->authex->isAangemeld()) {
            redirect('Welcome/logIn');
        } else {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->typePersoon->typePersoon != "trainer") {
                redirect('Welcome/logIn');
            }
        }
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /**Geeft de homepagina van de trainer weer met de ongelezen meldingen via Melding_model in de view trainer/home.php
     * Geeft een lijst van objecten melding door naar de view.
     * @author Neil Van den Broeck
     * @see \Melding_model::getAllFromPersoonAndNietGelezen()
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
