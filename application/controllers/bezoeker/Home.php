<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('notation');
    }

    public function index()
    {
        $data['titel'] = 'Welkom bezoeker!';

        $partials = array(
            'inhoud' => 'algemeen/home');

        $this->template->load('main_master', $partials, $data);
    }

    public function team()
    {
        $data['titel'] = 'Team';

        $this->load->model('persoon_model');

        $data['zwemmers'] = $this->persoon_model->getZwemmers();


        $partials = array(
            'inhoud' => 'bezoeker/team_lijst');

        $this->template->load('main_home', $partials, $data);
    }

    public function zwemmer($id)
    {
        $this->load->model('persoon_model');

        $zwemmer = $this->persoon_model->get($id);

        $data['titel'] = 'ZwemmerInfo - ' . $zwemmer->voornaam;
        $data['zwemmer'] = $zwemmer;


        $partials = array(
            'inhoud' => 'bezoeker/teamlidsinfo_bekijken');

        $this->template->load('main_home', $partials, $data);
    }
}
