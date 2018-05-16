<?php

class Wedstrijdresultaat extends CI_Controller
{
    /**
     * Wedstrijdresultaat constructor.
     * Indien de persoon niet is aangemeld wordt deze naar de loginpagina gestuurd.
     * Kan alleen als trainer worden opgeroepen.
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
     * Redirect de user naar de functie resultaten()
     * @author Dieter Verboven
     * @see trainer/wedstrijdresultaat/resultaten.php
     */

    public function index()
    {
        $this->resultaten();
    }

    /**
     * Haalt de aangemelde persoon uit de Authex-library.
     * Krijgt van de functie elke ronde, elke persoon en aan welke reeks, slag en afstand van deze reeks, een resultaat moet toegevoegd worden.
     * Geeft een in te vullen formulier weer waar men een nieuw resultaat kan .
     * @author Dieter Verboven
     * @see \rondetype_model::getAll()
     * @see \persoon_model::getZwemmers()
     * @see \wedstrijdreeks_model::getWithWedstrijdSlagAfstand()
     * @see trainer/wedstrijdresultaat_toevoegen.php
     */
    public function toevoegen($reeksId)
    {
        $data['titel'] = 'Resultaat toevoegen';
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->model('rondetype_model');
        $data["rondetypes"] = $this->rondetype_model->getAll();
        $this->load->model('persoon_model');
        $data['zwemmers'] = $this->persoon_model->getZwemmers();

        $this->load->model('wedstrijdreeks_model');
        $data['reeks'] = $this->wedstrijdreeks_model->getWithWedstrijdSlagAfstand($reeksId);
        $partials = array('inhoud' => 'trainer/wedstrijdresultaat_toevoegen',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Geeft een in te vullen formulier weer waar men een nieuw resultaat kan.
     * Geeft alle ingegeven gegevens uit het formulier door via een post en voegt daarna het resultaat en de wedstrijddeelname toe aan de database.
     * @author Dieter Verboven
     * @see \resultaat_model::insert()
     * @see \wedstrijdreeks_model::getWithWedstrijdSlagAfstand()
     * @see trainer/wedstrijdresultaat_toevoegen.php
     */
    public function aanmaken()
    {
        $resultaat = new stdClass();
        $resultaat->tijd = html_escape($this->input->post('tijd'));
        $resultaat->rondeTypeId = html_escape($this->input->post('rondetype'));
        $resultaat->ranking = html_escape($this->input->post('ranking'));
        $this->load->model('resultaat_model');
        $resultaatId = $this->resultaat_model->insert($resultaat);
        $wedstrijddeelname = new stdClass();
        $wedstrijddeelname->persoonId = html_escape($this->input->post('zwemmer'));
        $wedstrijddeelname->resultaatId = $resultaatId;
        $wedstrijddeelname->wedstrijdReeksId = html_escape($this->input->post('reeksId'));
        $wedstrijddeelname->statusId = '2';

        $this->load->model('wedstrijddeelname_model');
        $this->wedstrijddeelname_model->insert($wedstrijddeelname);
        return $this->resultatenbeheren(html_escape($this->input->post('wedstrijdId')));
    }

    /**
     * Haalt alle wedstrijden  en de bijhorende locaties op
     * Stuurt deze door naar de view
     * @author Dieter Verboven
     * @see \wedstrijd_model::getAllWithLocatie()
     * @see trainer/wedstrijdresultaten_beheren.php
     */
    public function resultaten()
    {
        $data['titel'] = 'Wedstrijdresultaten beheren';
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAllWithLocatie();
        $partials = array('inhoud' => 'trainer/wedstrijdresultaten_beheren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * @param id De id van de wedstrijd waarvan de gegevens moeten opgehaald worden.
     * Geeft alle reeksen, slagen en afstanden bij de reeksen van de meegegeven wedstrijd.
     * @see trainer/resultaten_aanpassen.php
     * @see wedstrijdreeks_model::getAllWithWedstrijdSlagAfstandById()
     * @see wedstrijd_model::get()
     * @author Dieter Verboven
     */
    public function resultatenBeheren($id)
    {
        $data['titel'] = 'Wedstrijdresultaten beheren';
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->model('wedstrijdreeks_model');
        $data['reeksen'] = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandById($id);
        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);
        $partials = array('inhoud' => 'trainer/wedstrijdresultaten_aanpassen',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * @param reeksId De id van de reeks waarvan de gegevens moeten opgehaald worden in wedstrijdresultaten_aanpassen.
     * Geeft alle resultaten, personen en rondes bij de reeks die is meegegeven.
     * @see trainer/ajax_haalResultatenOp.php
     * @see wedstrijddeelname_model::getAllWithPersoonResultaatById()
     * @see rondetype_model::getAll()
     * @author Dieter Verboven
     */
    public function resultatenOphalen()
    {
        $reeksId = $this->input->get('reeksId');
        $this->load->model('wedstrijddeelname_model');
        $data['wedstrijddeelnames'] = $this->wedstrijddeelname_model->getAllWithPersoonResultaatById($reeksId);

        $this->load->model('rondetype_model');
        $data["rondetypes"] = $this->rondetype_model->getAll();

        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->view("trainer/ajax_haalResultatenOp", $data);
    }

    /**
     * @param id De id van het resultaat waarvan de gegevens moeten opgehaald worden.
     * Haalt alle bijhorende gegegevens van het resultaat door, tijd, ronde, ranking, zwemmer ...op. Geeft een in te vullen formulier weer waar het gekozen resultaat kan aangepast worden.
     * @see trainer/wedstrijdresultaat_aanpassen.php
     * @see wedstrijddeelname_model::getDeelnemers()
     * @see wedstrijddeelname_model::getByResultaatId()
     * @see rondetype_model::getAll()
     * @see resultaat_model::get()
     * @author Dieter Verboven
     */
    public function resultatenAanpassen($id)
    {
        $data['titel'] = 'Wedstrijdresultaten aanpassen';
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->model('rondetype_model');
        $data["rondetypes"] = $this->rondetype_model->getAll();
        $this->load->model('wedstrijddeelname_model');
        $data['zwemmers'] = $this->wedstrijddeelname_model->getDeelnemers($id);
        $data['wedstrijddeelname'] = $this->wedstrijddeelname_model->getByResultaatId($id);

        $this->load->model('resultaat_model');
        $data['resultaat'] = $this->resultaat_model->get($id);


        $partials = array('inhoud' => 'trainer/wedstrijdresultaat_aanpassen',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Past het resultaat aan indien nodig
     * keert hierna terug naar de resultaten van een wedstrijd (wedstrijdresultaten_aanpassen.php)
     * @author Dieter Verboven
     * @see \wedstrijddeelname_model::update()
     * @see trainer/wedstrijdresultaten_aanpassen.php
     */
    public function pasAan()
    {
        $resultaat = new stdClass();
        $resultaat->tijd = html_escape($this->input->post('tijd'));
        $resultaat->rondeTypeId = html_escape($this->input->post('rondetype'));
        $resultaat->ranking = html_escape($this->input->post('ranking'));
        $resultaat->id = html_escape($this->input->post('id'));
        $this->load->model('resultaat_model');
        $this->resultaat_model->update($resultaat);

        $wedstrijddeelname = new stdClass();
        $wedstrijddeelname->persoonId = html_escape($this->input->post('zwemmer'));
        $wedstrijddeelname->resultaatId = html_escape($this->input->post('id'));
        $wedstrijddeelname->id = html_escape($this->input->post('wedstrijddeelnameId'));

        $this->load->model('wedstrijddeelname_model');
        $this->wedstrijddeelname_model->update($wedstrijddeelname);
        return $this->resultaten();
    }


}
