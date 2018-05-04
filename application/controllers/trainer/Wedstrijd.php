<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wedstrijd extends CI_Controller
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

    public function beheren()
    {
        $data['titel'] = 'Wedstrijden beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $data['error'] = "";

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAllWithLocatie();

        $partials = array('inhoud' => 'trainer/wedstrijden_beheren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function aanpassen($id)
    {
        $data['titel'] = 'Wedstrijd aanpassen';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $this->load->model('wedstrijdreeks_model');
        $data['wedstrijdreeksen'] = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandById($id);

        $partials = array('inhoud' => 'trainer/wedstrijd_aanpassen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function toevoegen($error)
    {
        $data['titel'] = 'Wedstrijd toevoegen';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        if($error == "nieuw"){
          $data['error'] = "";
        }else{
        $data['error'] = $error;
        }

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();

        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();

        $partials = array('inhoud' => 'trainer/wedstrijd_toevoegen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function aanmaken()
    {
        $wedstrijd = new stdClass();

        $wedstrijd->naam = $this->input->post('naam');
        $wedstrijd->locatieId = $this->input->post('locatie');

        $beginDatum = $this->input->post('begindatum');
        $wedstrijd->begindatum = $beginDatum;

        $eindDatum = $this->input->post('einddatum');
        $wedstrijd->einddatum = $eindDatum;

        $wedstrijd->extraInfo = $this->input->post('extraInfo');

        if($beginDatum != ""){
          $NieuweBeginDatum = new DateTime($beginDatum);
          $NieuweBeginDatumTime = $NieuweBeginDatum->getTimestamp();
        }else{
          $NieuweBeginDatumTime = 0;
        }

        if($eindDatum != ""){
          $NieuweEindDatum = new DateTime($eindDatum);
          $NieuweEindDatumTime = $NieuweEindDatum->getTimestamp();
        }else{
          $NieuweEindDatumTime = 0;
        }

        if($NieuweBeginDatumTime != 0 & $NieuweEindDatumTime != 0){
          if($NieuweBeginDatumTime <= $NieuweEindDatumTime){
            $this->load->model('wedstrijd_model');
            $wedstrijdId = $this->wedstrijd_model->insert($wedstrijd);
            $data['id'] = $wedstrijdId;

            $this->load->model('persoon_model');
            $this->melding->genereerMeldingen($this->persoon_model->getZwemmers(), 'Er is een nieuwe wedstrijd ' . $wedstrijd->naam . ' toegevoegd', 'Nieuwe Wedstrijd');
            return $this->beheren();
          }else{
            $error = "Toevoegen mislukt! De einddatum valt voor de begindatum";
            return $this->toevoegen($error);
          }
        }else{
          $this->load->model('wedstrijd_model');
          $wedstrijdId = $this->wedstrijd_model->insert($wedstrijd);
          $data['id'] = $wedstrijdId;

          $this->load->model('persoon_model');
          $this->melding->genereerMeldingen($this->persoon_model->getZwemmers(), 'Er is een nieuwe wedstrijd ' . $wedstrijd->naam . ' toegevoegd', 'Nieuwe Wedstrijd');
          return $this->beheren();
        }

    }

    public function pasAan()
    {
        $wedstrijd = new stdClass();

        $wedstrijd->naam = $this->input->post('naam');
        $wedstrijd->locatieId = $this->input->post('locatie');
        $wedstrijd->begindatum = $this->input->post('begindatum');
        $wedstrijd->einddatum = $this->input->post('einddatum');
        $wedstrijd->extraInfo = $this->input->post('extraInfo');
        $wedstrijd->id = $this->input->post('id');

        $this->load->model('wedstrijd_model');
        $this->wedstrijd_model->update($wedstrijd);

        return $this->beheren();
    }

    public function verwijder($id)
    {
        $data['titel'] = 'Wedstrijden beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAllWithLocatie();

        $this->load->model('wedstrijd_model');
        $data['error'] = $this->wedstrijd_model->delete($id);

        $partials = array('inhoud' => 'trainer/wedstrijden_beheren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function resultaten()
    {
        $data['titel'] = 'Wedstrijdresultaten beheren';
        $data['eindverantwoordelijke'] = "";
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
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijdreeks_model');
        $data['reeksen'] = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandById($id);

        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);

        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();

        $partials = array('inhoud' => 'trainer/wedstrijdresultaat_aanpassen',
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


}
