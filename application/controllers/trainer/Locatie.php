<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Locatie extends CI_Controller {

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
        
    public function beheren() {
        $data['titel']  = 'Locaties beheren';

            $this->load->model('locatie_model');
            $data['locaties'] = $this->locatie_model->getAll();

            $partials = array('inhoud' => 'trainer/locatie_beheren');

            $this->template->load('main_master', $partials, $data);
    }
}