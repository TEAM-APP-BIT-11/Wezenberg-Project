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
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['titel'] = 'Welkom';
        $this->load->model('nieuwsitem_model');
        $this->load->model('wedstrijd_model');
         $data['nieuwsitems']= $this->nieuwsitem_model->getNieuws();
        $data['kalender']= $this->wedstrijd_model->getAllAfterTodayWithLocatie();
        $partials = array(
            'inhoud' => 'algemeen/home',
            'footer' => 'main_footer');
        $this->template->load('main_home', $partials, $data);
    }

    public function logIn()
    {
        $data['titel'] = "Login";
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        if ($this->authex->isAangemeld()) {
            $persoon = $this->authex->getPersoonInfo();
            switch ($persoon->typePersoon->typePersoon) {
                case 'zwemmer':
                    redirect('zwemmer/Home');
                    break;
                case 'trainer':
                    redirect('trainer/Home');
                    break;
            }
        }

        $partials = array(
            'inhoud' => 'algemeen/inloggen',
            'footer' => 'main_footer');
        $this->template->load('main_home', $partials, $data);
    }

    /**
     * @param $id De id van de persoon die aangemeld is waarvan de gegevens moeten opgehaald worden.
     * Geeft een formulier weer waar de gebruiker zijn gegevens kan aanpassen.
     * @see algemeen/profiel_beheren.php
     * @see algemeen/fout_wijzigen.php
     * @see persoon_model::get()
     * @author Dieter Verboven
     */
    public function wijzig($id)
    {
        $persoon = $this->authex->getPersoonInfo();

        $data['eindverantwoordelijke'] = "Dieter Verboven";

        if ($persoon->id == $id) {
            $data['titel'] = "Profiel wijzigen";
            $this->load->model('persoon_model');
            $data['persoon'] = $this->persoon_model->get($id);
            $partials = array('hoofding' => 'main_header',
                'inhoud' => 'algemeen/profiel_beheren',
                'footer' => 'main_footer');


        } else {
            $data["titel"] = "Fout!";
            $data['error'] = "Er is iets fout gelopen! U kan dit niet aanpassen!";

            $partials = array('hoofding' => 'main_header',
                'inhoud' => 'algemeen/fout_wijzigen',
                'footer' => 'main_footer');
        }
        $this->template->load('main_master', $partials, $data);

    }

    /**
     * @param $id De id van de persoon die aangemeld is.
     * Geeft een formulier weer waar de gebruiker zijn wachtwoord kan aanpassen.
     * @see algemeen/reset_wachtwoord.php
     * @see algemeen/fout_wijzigen.php
     * @see persoon_model::get()
     * @author Dieter Verboven
     */
    function wachtwoord($id)
    {
        $persoon = $this->authex->getPersoonInfo();

        $data['eindverantwoordelijke'] = "Dieter Verboven";

        if ($persoon->id == $id) {
            $data['titel'] = "Wachtwoord wijzigen";

            $this->load->model('persoon_model');
            $data['persoon'] = $this->persoon_model->get($id);

            $partials = array('hoofding' => 'main_header',
                'inhoud' => 'algemeen/reset_wachtwoord',
                'footer' => 'main_footer');
        } else {
            $data["titel"] = "Fout!";
            $data['error'] = "Er is iets fout gelopen! U kan dit niet aanpassen!";

            $partials = array('hoofding' => 'main_header',
                'inhoud' => 'algemeen/fout_wijzigen',
                'footer' => 'main_footer');
        }
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt de gegevens uit het formulier op en past de gegevens van de ingelogde persoon aan in de database
     * @see algemeen/profiel_beheren.php
     * @see persoon_model::update()
     * @author Dieter Verboven
     */
    function registreer()
    {
        $persoon = new stdClass();

        $persoon->id = $this->input->post('id');
        $persoon->voornaam = html_escape($this->input->post('voornaam'));
        $persoon->familienaam = html_escape($this->input->post('familienaam'));
        $persoon->straat = html_escape($this->input->post('straat'));
        $persoon->nummer = html_escape($this->input->post('nummer'));
        $persoon->mailadres = html_escape($this->input->post('mailadres'));
        $persoon->gsmnummer = html_escape($this->input->post('gsmnummer'));
        $persoon->woonplaats = html_escape($this->input->post('gemeente'));
        $persoon->postcode = html_escape($this->input->post('postcode'));
        $persoon->biografie = html_escape($this->input->post('biografie'));
        $fotonaam = html_escape(str_replace(' ','',$persoon->voornaam . $persoon->familienaam . '.jpg'));
        $persoon->foto = $fotonaam;

        $config['upload_path'] = './resources/img/personen/';
        $config['allowed_types'] = 'jpg';
        $config['max_size'] = 2000;
        $config['file_name'] = $fotonaam;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            $error = array('error' => $this->upload->display_errors());

            var_dump($error);
        }

        $this->load->model('persoon_model');

        if ($persoon->id == 0) {
            $this->persoon_model->insert($persoon);
        } else {
            $this->persoon_model->update($persoon);
        }
        $this->index();
    }

    /**
     * Haalt het nieuwe wachtwoord uit het formulier op en past deze van de ingelogde persoon aan in de database
     * @see algemeen/reset_wachtwoord.php
     * @see persoon_model::update()
     * @author Dieter Verboven
     */
    function wijzigWachtwoord()
    {
        $persoon = new stdClass();

        $persoon->id = $this->input->post('id');


        $persoon->wachtwoord = password_hash($this->input->post('nieuw'), PASSWORD_DEFAULT);


        $this->load->model('persoon_model');

        if ($persoon->id == 0) {
            $this->persoon_model->insert($persoon);
        } else {
            $this->persoon_model->update($persoon);
        }

    }

    public function fout()
    {
        $data['titel'] = "Fout";
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        $data['error'] = "Er is iets fout gelopen, probeer opnieuw!";

        $partials = array(
            'inhoud' => 'algemeen/fout_inloggen',
            'footer' => 'main_footer');
        $this->template->load('main_home', $partials, $data);
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
            redirect('Welcome/fout');
        }
    }

    public function MeldingGelezen()
    {
        $meldingId = $this->input->post('meldingId');

        $this->load->model('melding_model');
        $melding = $this->melding_model->get($meldingId);
        $melding->gelezen = 1;
        $this->melding_model->update($melding);

        return 'ok';
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
