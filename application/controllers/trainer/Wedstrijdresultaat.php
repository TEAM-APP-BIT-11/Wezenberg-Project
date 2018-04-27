<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Wedstrijdresultaat extends CI_Controller
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
            if ($persoon->typePersoon->typePersoon !== "trainer") {
                redirect('');
            }
        }
        $this->load->helper('form');
        $this->load->helper('notation');
    }
    public function index()
    {
        $this->load->view('welcome_message');
    }

    /**
     * Haalt de aangemelde persoon uit de Authex-library.
     * Krijgt van de functie de elke ronde, elke persoon en aan welke reeks, slag en afstand van deze reeks, een resultaat moet toegevoegd worden.
     * Geeft een in te vullen formulier weer waar men een nieuw resultaat kan .
     * @author Dieter Verboven
     * @see \rondetype_model::getAll()
     * @see \persoon_model::getZwemmers()
     * @see \wedstrijdreeks_model::getWithWedstrijdSlagAfstand()
     * @see zwemmer/ajax_innames
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
    public function aanmaken()
    {
        $resultaat = new stdClass();
        $resultaat->tijd = $this->input->post('tijd');
        $resultaat->rondeTypeId = $this->input->post('rondetype');
        $resultaat->ranking = $this->input->post('ranking');
        $this->load->model('resultaat_model');
        $resultaatId = $this->resultaat_model->insert($resultaat);
        $wedstrijddeelname = new stdClass();
        $wedstrijddeelname->persoonId = $this->input->post('zwemmer');
        $wedstrijddeelname->resultaatId = $resultaatId;
        $wedstrijddeelname->wedstrijdReeksId = $this->input->post('reeksId');
        $wedstrijddeelname->statusId = '2';
        
        $this->load->model('wedstrijddeelname_model');
        $this->wedstrijddeelname_model->insert($wedstrijddeelname);
        return $this->resultaten();
        // var_dump($wedstrijd);
    }
    public function pasAan()
    {
        $resultaat = new stdClass();
        $resultaat->tijd = $this->input->post('tijd');
        $resultaat->rondeTypeId = $this->input->post('rondetype');
        $resultaat->ranking = $this->input->post('ranking');
        $resultaat->id = $this->input->post('id');
        $this->load->model('resultaat_model');
        $this->resultaat_model->update($resultaat);
        
        $wedstrijddeelname = new stdClass();
        $wedstrijddeelname->persoonId = $this->input->post('zwemmer');
        $wedstrijddeelname->resultaatId = $this->input->post('id');
        $wedstrijddeelname->id = $this->input->post('wedstrijddeelnameId');
        
        $this->load->model('wedstrijddeelname_model');
        $this->wedstrijddeelname_model->update($wedstrijddeelname);
        return $this->resultaten();
    }
    public function verwijder($id)
    {
        $this->load->model('wedstrijd_model');
        $this->wedstrijd_model->delete($id);
        return $this->beheren();
    }
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
    public function resultatenBeheren($id)
    {
        $data['titel'] = 'Wedstrijdresultaten beheren';
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->model('wedstrijdreeks_model');
        $data['reeksen'] = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandById($id);
        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);
        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();
        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();
        $partials = array('inhoud' => 'trainer/wedstrijdresultaten_aanpassen',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    public function resultatenOphalen()
    {
        $reeksId = $this->input->get('reeksId');
        $this->load->model('wedstrijddeelname_model');
        $data['wedstrijddeelnames'] = $this->wedstrijddeelname_model->getAllWithPersoonResultaatById($reeksId);
        $this->load->model('rondetype_model');
        $data["rondetypes"] = $this->rondetype_model->getAll();
        $data["personen"] = $this->wedstrijddeelname_model->getAllWithPersoonResultaatById($reeksId);
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->view("trainer/ajax_haalResultatenOp", $data);
    }
    
    public function resultatenAanpassen($id)
    {
        $data['titel'] = 'Wedstrijdresultaten aanpassen';
        $data['eindverantwoordelijke'] = "Dieter Verboven";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->model('rondetype_model');
        $data["rondetypes"] = $this->rondetype_model->getAll();
        $this->load->model('wedstrijddeelname_model');
        $data['zwemmers'] = $this->wedstrijddeelname_model->getDeelnemers($id);     
        
        $this->load->model('resultaat_model');
        $data['resultaat'] = $this->resultaat_model->get($id);
        
        $this->load->model('wedstrijddeelname_model');
        $data['wedstrijddeelname'] = $this->wedstrijddeelname_model->getByResultaatId($id);
        $partials = array('inhoud' => 'trainer/wedstrijdresultaat_aanpassen',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    
}