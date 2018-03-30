<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index()
    {
        redirect('zwemmer/Wedstrijd/inschrijven');
    }

    public function schrijfIn($wedstrijdReeksId)
    {
        //voeg een nieuwe record toe in de database met standaardwaardes.
        //Status op 1 = in afwachting --> standaard voor een ingeschrijving.
        $wedstrijdDeelname = new stdClass();

        $persoon = $this->authex->getPersoonInfo();

        $wedstrijdDeelname->persoonId = $persoon->id;
        $wedstrijdDeelname->wedstrijdReeksId = $wedstrijdReeksId;
        $wedstrijdDeelname->resultaatId = null;
        $wedstrijdDeelname->statusId = '1';
        $wedstrijdDeelname->ranking = null;

        $this->load->model("wedstrijddeelname_model");
        $this->wedstrijddeelname_model->insert($wedstrijdDeelname);
        redirect('/zwemmer/Wedstrijd/inschrijven/' . $wedstrijdReeksId);
    }


    public function schrijfUit($wedstrijdDeelnameId)
    {
        $this->load->model('wedstrijddeelname_model');
        $wedstrijdDeelname = $this->wedstrijddeelname_model->get($wedstrijdDeelnameId);
        // verwijderd de record uit de database met de het ID dat doorgegeven wordt

        $this->wedstrijddeelname_model->delete($wedstrijdDeelnameId);

        redirect('/zwemmer/Wedstrijd/inschrijven/' . $wedstrijdDeelname->wedstrijdReeksId);
    }

    public function inschrijven($wedstrijd = 0)
    {
        $data['titel'] = 'Inschrijven voor een Wedstrijd';

        $this->load->model('wedstrijd_model');

        $data['wedstrijden'] = $this->wedstrijd_model->getAll();

        $data['tonen'] = $wedstrijd;

        $partials = array(
            'inhoud' => 'zwemmer/wedstrijd_aanvragen');
        $this->template->load('main_master', $partials, $data);
    }


    public function haalJsonOp_WedstrijdReeksen()
    {

        $id = $this->input->get('wedstrijdId');

        $this->load->model('wedstrijdreeks_model');
        $persoon = $this->authex->getPersoonInfo();
        $wedstrijdreeksen = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandAndDeelnamePersoon($persoon->id, $id);

        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->datum = zetOmNaarDDMMYYYY($wedstrijdreeks->datum);
        }

        echo json_encode($wedstrijdreeksen);
    }

}
