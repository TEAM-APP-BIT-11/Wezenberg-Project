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

    /**
     * Haalt alle zwemmers en trianers op
     * Stuurt deze door naar de view gebruikers_beheren.php waar men een actie kan kiezen
     * @author Dieter Verboven
     * @see \persoon_model::getZwemmers()
     * @see \persoon_model::getTrainers()
     * @see trainer/gebruikers_beheren.php
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
    /**
     * @param ^$id De id van de persoon waarvan de gegevens moeten opgehaald worden.
     * Geeft een formulier weer waar men de gegevens van de gekozen persoon kan aanpassen.
     * @see trainer/gebruiker_aanpassen.php
     * @see persoon_model::get()
     * @see typepersoon_model::getAll()
     * @author Dieter Verboven
     */
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
    /**
     * Geeft een in te vullen formulier weer waar men een nieuwe gebruiker kan toevoegen.
     * @author Dieter Verboven
     * @see \typepersoon_model::getAll()
     * @see trainer/gebruiker_toevoegen.php
     */
    public function toevoegen()
    {
        $data['titel'] = "Gebruiker toevoegen";
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        
        $this->load->model('typepersoon_model');
        $data['types'] = $this->typepersoon_model->getAll();

        $partials = array('inhoud' => 'trainer/gebruiker_toevoegen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    /**
     * Past het aangepaste formulier toe op de betrokken persoon.
     * @author Dieter Verboven
     * @see \persoon_model::update()
     * @see trainer/gebruiker_aanpassen.php
     */
    public function pasAan()
    {
        $persoon = new stdClass();
        $persoon->id = html_escape($this->input->post('id'));
        $persoon->typePersoonId = html_escape($this->input->post('type'));
        $persoon->voornaam = html_escape($this->input->post('voornaam'));
        $persoon->familienaam = html_escape($this->input->post('familienaam'));
        $persoon->geboortedatum = html_escape($this->input->post('geboortedatum'));
        $persoon->straat = html_escape($this->input->post('straat'));
        $persoon->nummer = html_escape($this->input->post('nummer'));
        $persoon->mailadres = html_escape($this->input->post('mailadres'));
        $persoon->gsmnummer = html_escape($this->input->post('gsmnummer'));
        $persoon->woonplaats = html_escape($this->input->post('woonplaats'));
        $persoon->postcode = html_escape($this->input->post('postcode'));
        $persoon->biografie = html_escape($this->input->post('biografie'));
        $persoon->gebruikersnaam = html_escape($this->input->post('gebruikersnaam'));

        $this->load->model('persoon_model');

        $this->persoon_model->update($persoon);

        $this->beheren();
    }
    
    /**
     * Voegt de ingevulde gegevens uit het formulier toe aan de database als een nieuwe persoon.
     * @author Dieter Verboven
     * @see \persoon_model::insert()
     * @see trainer/gebruiker_toevoegen.php
     */
    public function voegToe()
    {
        $persoon = new stdClass();
        
        $type = html_escape($this->input->post('type'));

        $persoon->typePersoonId = $type;
        $persoon->voornaam = html_escape($this->input->post('voornaam'));
        $persoon->familienaam = html_escape($this->input->post('familienaam'));
        $persoon->geboortedatum = html_escape($this->input->post('geboortedatum'));
        $persoon->straat = html_escape($this->input->post('straat'));
        $persoon->nummer = html_escape($this->input->post('nummer'));
        $persoon->mailadres = html_escape($this->input->post('mailadres'));
        $persoon->gsmnummer = html_escape($this->input->post('gsmnummer'));
        $persoon->woonplaats = html_escape($this->input->post('woonplaats'));
        $persoon->postcode = html_escape($this->input->post('postcode'));
        $persoon->biografie = html_escape($this->input->post('biografie'));
        $persoon->gebruikersnaam = html_escape($this->input->post('gebruikersnaam'));
        if ($type == 1)
        {
            $persoon->wachtwoord = html_escape(password_hash('trainer123', PASSWORD_DEFAULT)) ;
        }
        else
        {
            $persoon->wachtwoord = html_escape(password_hash('zwemmer123', PASSWORD_DEFAULT));
        }
        $persoon->actief = '1';

        $this->load->model('persoon_model');

        $this->persoon_model->insert($persoon);
        

        $this->beheren();
    }
    /**
     * Past de activiteitsstatus aan van een gebruiker.
     * @param De id van de persoon waar actief moet aangepast worden.
     * @author Dieter Verboven
     * @see \persoon_model::update()
     * @see \persoon_model::get()
     * @see trainer/gebruikers_beheren.php
     */
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
