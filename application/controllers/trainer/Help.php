<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Help extends CI_Controller
{

    /**
     * Help constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('html');

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

    public function index()
    {
        $data['titel'] = 'Help functie';
        $data['eindverantwoordelijke'] = "Stef Schoeters en Senne Cools";
        $persoon = $this->authex->getPersoonInfo();

        $partials = array(
            'inhoud' => 'trainer/help',
            'footer' => 'main_footer');

        $this->template->load('main_help', $partials, $data);
    }
}
