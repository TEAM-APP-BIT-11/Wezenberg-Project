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
        $this->load->helper('url');
    }

    public function index()
    {
        $data['titel'] = "Indexpagina";

        $partials = array(
            'inhoud' => 'algemeen/home');
        $this->template->load('main_master', $partials, $data);
    }

    public function logIn()
    {
        $data['titel'] = "Login";

        $partials = array(
            'inhoud' => 'algemeen/inloggen');
        $this->template->load('main_master', $partials, $data);
    }

    public function wijzig($id)
    {
        $data['titel'] = "Profiel wijzigen";

        $this->load->model('persoon_model');
        $data['persoon'] = $this->persoon_model->get($id);

        $partials = array('hoofding' => 'main_header',
            'inhoud' => 'algemeen/profiel_beheren',
            'voetnoot' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    function registreer()
    {
        $persoon = new stdClass();

        $persoon->id = $this->input->post('id');
        $persoon->voornaam = $this->input->post('voornaam');
        $persoon->familienaam = $this->input->post('familienaam');
        $persoon->straat = $this->input->post('straat');
        $persoon->nummer = $this->input->post('nummer');
        $persoon->mailadres = $this->input->post('mailadres');
        $persoon->gsmnummer = $this->input->post('gsmnummer');
        $persoon->woonplaats = $this->input->post('gemeente');
        $persoon->postcode = $this->input->post('postocde');
        $persoon->biografie = $this->input->post('biografie');

        $this->load->model('persoon_model');

        if ($persoon->id == 0) {
            $this->persoon_model->insert($persoon);
        } else {
            $this->persoon_model->update($persoon);
        }

        redirect('/welcome/index');
    }

    public function controleerAanmelden()
    {
        $gebruikersnaam = $this->input->post('gebruikersnaam');
        $wachtwoord = $this->input->post('wachtwoord');

        if ($this->authex->meldAan($gebruikersnaam, $wachtwoord)) {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->typePersoon->typePersoon == "zwemmer") {
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
            'inhoud' => 'trainer/home');
        $this->template->load('main_master', $partials, $data);
    }

    public function meldAf()
    {
        $this->authex->meldAf();
        redirect('Welcome/index');
    }
}
