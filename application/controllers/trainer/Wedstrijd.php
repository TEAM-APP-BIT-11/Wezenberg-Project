<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wedstrijd extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
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
            if ($persoon->typePersoonId != 1) {
                redirect('trainer/locatie');
            }
        }

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function beheren()
    {
        $data['titel'] = 'Wedstrijden beheren';
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAll();

        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/wedstrijden_beheren');
        $this->template->load('main_master', $partials, $data);
    }

    public function aanpassen($id)
    {
        $data['titel'] = 'Wedstrijd beheren';
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);

        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/wedstrijd_aanpassen');

        $this->template->load('main_master', $partials, $data);
    }
}
