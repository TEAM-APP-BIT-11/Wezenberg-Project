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
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAllWithLocatie();

        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/wedstrijden_beheren');
        $this->template->load('main_master', $partials, $data);
    }

    public function aanpassen($id)
    {
        $data['titel'] = 'Wedstrijd aanpassen';
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $this->load->model('wedstrijdreeks_model');
        $data['wedstrijdreeksen'] = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandById($id);

        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/wedstrijd_aanpassen');

        $this->template->load('main_master', $partials, $data);
    }

    public function toevoegen()
    {
        $data['titel'] = 'Wedstrijd toevoegen';
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();

        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();

        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/wedstrijd_toevoegen');

        $this->template->load('main_master', $partials, $data);
    }

    public function aanmaken()
    {
        $wedstrijd = new stdClass();

        $wedstrijd->naam = $this->input->post('naam');
        $wedstrijd->locatieId = $this->input->post('locatie');
        $wedstrijd->begindatum = $this->input->post('begindatum');
        $wedstrijd->einddatum = $this->input->post('einddatum');
        $wedstrijd->extraInfo = $this->input->post('extraInfo');

        $this->load->model('wedstrijd_model');
        $wedstrijdId = $this->wedstrijd_model->insert($wedstrijd);
        $data['id'] = $wedstrijdId;

        return $this->beheren();
        // var_dump($wedstrijd);
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
        // var_dump($wedstrijd);
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
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijddeelname_model');
        $data['wedstrijddeelnames'] = $this->wedstrijddeelname_model->getAllAndWedstrijdenWhereResultaatIsNotNull();

        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/wedstrijdresultaten_beheren');
        $this->template->load('main_master', $partials, $data);
    }
}
