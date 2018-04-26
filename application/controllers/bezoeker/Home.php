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
        $data['eindverantwoordelijke'] = 'Iemand';

        $this->load->model('persoon_model');

        $data['zwemmers'] = $this->persoon_model->getZwemmers();


        $partials = array(
            'inhoud' => 'bezoeker/team_lijst',
            'footer' => 'main_footer');

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
	public function resultaten(){
        $this->load->model('wedstrijd_model');
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['titel'] = 'Resultaten van de wedstrijden bekijken';
       
        $data['wedstrijden'] = $this->wedstrijd_model->getAll();
        
        $partials = array(
            'inhoud' => 'bezoeker/wedstrijd_resultaat' ,'footer' => 'main_footer');

        $this->template->load('main_home', $partials, $data);
    }
    
    public function resultaatDetail($id){
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        
        $this->load->model('wedstrijd_model');
        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijddeelname_model');
        $this->load->model('persoon_model');
        $data['wedstrijdnaam'] = $this->wedstrijd_model->get($id);
        $data['personen'] = $this->persoon_model->getAll();
        
        $data['titel'] = 'Wedstrijd';
        
        $data['slagen'] = $this->wedstrijdreeks_model->getReeksenSlag($id);
        $data['deelnamens'] = $this->wedstrijddeelname_model->getDeelnamensResultaten();
        
        $partials = array(
            'inhoud' => 'bezoeker/wedstrijd_details_bezoeker' ,'footer' => 'main_footer');

        $this->template->load('main_home', $partials, $data);
    }
}
