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

    public function index()
    {
        $data['titel'] = 'Home van de Zwemmer';
        $persoon = $this->authex->getPersoonInfo();
        $data['persoon'] = $persoon;
        $data['eindverantwoordelijke'] = "Iemand ? ";

        // moet variabele worden uit de sessie na het inloggen.

        $this->load->model('melding_model');
        $data['meldingen'] = $this->melding_model->getAllFromPersoonAndNietGelezen($persoon->id);

        $partials = array(
            'inhoud' => 'zwemmer/home',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }
}
