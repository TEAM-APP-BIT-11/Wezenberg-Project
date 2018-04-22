<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class wedstrijdresultaten extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
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
        $this->load->helper('notation');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function bekijken()
    {
        $persoon = $this->authex->getPersoonInfo();

        $data['titel']  = 'Persoonlijke wedstrijdresultaten bekijken';

        $this->load->model('wedstrijddeelname_model');
        $data['wedstrijddeelnames'] = $this->wedstrijddeelname_model->getAllWithWedstrijdByPersoon($persoon->id);

        $partials = array(
            'inhoud' => 'zwemmer/persoonlijke_resultaten');

        $this->template->load('main_master', $partials, $data);
    }

    public function haalAjaxOp_Resultaten()
    {
        $persoon = $this->authex->getPersoonInfo();

        $wedstrijdId = $this->input->get('id');

        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijddeelname_model');

        $wedstrijdreeksen = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandById($wedstrijdId);
        $data['wedstrijddeelnames'] = $this->wedstrijddeelname_model->getAllWithWedstrijdAndResultaatByPersoon($persoon->id, $wedstrijdreeksen);

      $this->load->view("zwemmer/ajax_haalResultatenOp", $data);
    }
}
