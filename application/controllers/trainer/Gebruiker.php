<?php

/*
 * @class Evenement
 * @brief Controller-klasse voor evenementen
 * 
 * Controller-klasse met alle methodes die gebruikt worden in vervand met evenementen
 */

class Gebruiker extends CI_Controller
{

    /*
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->authex->isAangemeld()) {
            redirect('Welcome/logIn');
        } else {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->typePersoon->typePersoon !== "trainer") {
                redirect('');
            }
        }

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /*
     * Haalt alle evenement-records op via Evenement_model en toont de lijst in de view evenementen_beheren.php
     * 
     * @see Evenement_mode::getAll()
     * @see evenementen_beheren.php
     */
    public function beheren()
    {
        $data['titel'] = "Gebruikers beheren";
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        $this->load->model('persoon_model');
        $data['zwemmers'] = $this->persoon_model->getZwemmers();
        $data['trainers'] = $this->persoon_model->getTrainers();

        $partials = array('inhoud' => 'trainer/gebruikers_beheren', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function aanpassen($id)
    {
        $data['titel'] = "Gebruiker aanpassen";
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        
        $this->load->model('persoon_model');
        $data['persoon'] = $this->persoon_model->get($id);
        
        $this->load->model('typepersoon_model');
        $data['types'] = $this->typepersoon_model->getAll();

        $partials = array('inhoud' => 'trainer/gebruiker_aanpassen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function toevoegen()
    {
        $data['titel'] = "Gebruiker toevoegen";
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        
        $this->load->model('typepersoon_model');
        $data['types'] = $this->typepersoon_model->getAll();

        $partials = array('inhoud' => 'trainer/gebruiker_toevoegen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function pasAan()
    {
        $persoon = new stdClass();

        $persoon->id = $this->input->post('id');
        $persoon->typePersoonId = $this->input->post('type');
        $persoon->voornaam = $this->input->post('voornaam');
        $persoon->familienaam = $this->input->post('familienaam');
        $persoon->geboortedatum = $this->input->post('geboortedatum');
        $persoon->straat = $this->input->post('straat');
        $persoon->nummer = $this->input->post('nummer');
        $persoon->mailadres = $this->input->post('mailadres');
        $persoon->gsmnummer = $this->input->post('gsmnummer');
        $persoon->woonplaats = $this->input->post('woonplaats');
        $persoon->postcode = $this->input->post('postcode');
        $persoon->gebruikersnaam = $this->input->post('gebruikersnaam');

        $this->load->model('persoon_model');

        $this->persoon_model->update($persoon);
        

        $this->beheren();
    }
    
    
    public function voegToe()
    {
        $persoon = new stdClass();
        
        $type = $this->input->post('type');

        $persoon->typePersoonId = $type;
        $persoon->voornaam = $this->input->post('voornaam');
        $persoon->familienaam = $this->input->post('familienaam');
        $persoon->geboortedatum = $this->input->post('geboortedatum');
        $persoon->straat = $this->input->post('straat');
        $persoon->nummer = $this->input->post('nummer');
        $persoon->mailadres = $this->input->post('mailadres');
        $persoon->gsmnummer = $this->input->post('gsmnummer');
        $persoon->woonplaats = $this->input->post('woonplaats');
        $persoon->postcode = $this->input->post('postcode');
        $persoon->gebruikersnaam = $this->input->post('gebruikersnaam');
        if ($type == 1)
        {
            $persoon->wachtwoord = password_hash('trainer123', PASSWORD_DEFAULT) ;
        }
        else
        {
            $persoon->wachtwoord = password_hash('zwemmer123', PASSWORD_DEFAULT);
        }
        $persoon->actief = '1';

        $this->load->model('persoon_model');

        $this->persoon_model->insert($persoon);
        

        $this->beheren();
    }
    
     public function activiteitVeranderen($id)
    {
        $this->load->model('persoon_model'); 
        $persoon = $this->persoon_model->get($id);
        
        if($persoon->actief == 1)
        {
            $persoon->actief = '0';
        } 
        else
        {
            $persoon->actief = '1';
        }

        $this->persoon_model->update($persoon);
        

        $this->beheren();
    }
}
