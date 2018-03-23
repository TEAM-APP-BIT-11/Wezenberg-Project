<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
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
        $this->load->helper('notation');
    }

    public function index()
    {
        $this->load->helper('url');
        $data['persoon'] = $this->authex->getPersoonInfo();

        $partials = array(
            'inhoud' => 'algemeen/inloggen');
        $this->template->load('main_master', $partials, $data);
    }

    public function logIn()
    {
        $this->load->helper('url');
        $data['persoon'] = $this->authex->getPersoonInfo();

        $partials = array(
            'inhoud' => 'algemeen/inloggen');
        $this->template->load('main_master', $partials, $data);
    }

    public function controleerAanmelden()
    {
        $gebruikersnaam = $this->input->post('gebruikersnaam');
        $wachtwoord = $this->input->post('wachtwoord');

        if ($this->authex->meldAan($gebruikersnaam, $wachtwoord)) {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->typePersoonId == 2) {
                redirect('zwemmer/Home');
            } else {
                redirect('trainer/Home');
            }

        } else {
            //fout 
            redirect('Welcome/index');
        }
        echo $this->authex->meldAan($gebruikersnaam, $wachtwoord);
    }

    public function toon()
    {
        $data['titel'] = 'Formulier met dialoogvenster';

        $partials = array(
            'menuGebruiker' => 'trainer_menu',
            'inhoud' => 'trainer/home');
        $this->template->load('main_master', $partials, $data);
    }

    public function meldAf()
    {
        $this->authex->meldAf();
        redirect('Welcome/index');
    }
}
