<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wedstrijd extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
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
		$this->load->view('welcome_message');
	}

    public function schrijfIn($wedstrijdReeksId){

        //voeg een nieuwe record toe in de database met standaardwaardes.
        //Status op 1 = in afwachting --> standaard voor een ingeschrijving.
        $wedstrijdDeelname = new stdClass();

        $wedstrijdDeelname->persoonId = "2";
        $wedstrijdDeelname->wedstrijdReeksId = $wedstrijdReeksId;
        $wedstrijdDeelname->resultaatId = null;
        $wedstrijdDeelname->statusId = '1';
        $wedstrijdDeelname->ranking = null;

        $this->load->model("wedstrijddeelname_model");
        $this->wedstrijddeelname_model->insert($wedstrijdDeelname);

        redirect('/zwemmer/Wedstrijd/inschrijven');
}

public function schrijfUit($wedstrijdDeelnameId){
        // verwijderd de record uit de database met de het ID dat doorgegeven wordt
        $this->load->model('wedstrijddeelname_model');
        $this->wedstrijddeelname_model->delete($wedstrijdDeelnameId);

        redirect('/zwemmer/Wedstrijd/inschrijven');
}
    public function inschrijven() {
        $data['titel'] = 'Inschrijven voor een Wedstrijd';
        $data['naam'] = 'Neil';

        $this->load->model('wedstrijd_model');

        $data['wedstrijden'] = $this->wedstrijd_model->getAll();

        $partials = array(
            'menuGebruiker' => 'zwemmer_menu',
            'inhoud' => 'zwemmer/wedstrijd_aanvragen');
        $this->template->load('main_master', $partials, $data);
    }

    public function haalJsonOp_WedstrijdReeksen(){

        $id = $this->input->get('wedstrijdId');

        $this->load->model('wedstrijdreeks_model');
        $wedstrijdreeksen = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandAndDeelnamePersoon(2, $id);

        echo json_encode($wedstrijdreeksen);

        //todo: MOET NOG UITGESCHREVEN WORDEN
        //Hierboven enkel wedstrijd meegeven en dan met json de rest ophalen.
    }

}
