<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Locatie extends CI_Controller
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
        $this->template->load('main_master', $partials, $data);
    }

    public function beheren()
    {
        $data['titel'] = 'Locaties beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $data['error'] = "";

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $partials = array(
            'inhoud' => 'trainer/locatie_beheren',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function aanpassen($id)
    {
        $data['titel'] = 'Locatie beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('locatie_model');
        $data['locatie'] = $this->locatie_model->get($id);

        $partials = array(
            'inhoud' => 'trainer/locatie_aanpassen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function pasAan()
    {
        $locatie = new stdClass();

        $locatie->naam = html_escape($this->input->post('naam'));
        $locatie->straat = html_escape($this->input->post('straat'));
        $locatie->nr = html_escape($this->input->post('nr'));
        $locatie->postcode = html_escape($this->input->post('postcode'));
        $locatie->gemeente = html_escape($this->input->post('gemeente'));
        $locatie->zaal = html_escape($this->input->post('zaal'));
        $locatie->land = html_escape($this->input->post('land'));
        $locatie->extraInfo = html_escape($this->input->post('extraInfo'));
        $locatie->id = html_escape($this->input->post('id'));

        $this->load->model('locatie_model');
        $this->locatie_model->update($locatie);

        return $this->beheren();
    }

    public function toevoegen()
    {
        $data['titel'] = 'Locatie beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('locatie_model');

        $partials = array(
            'inhoud' => 'trainer/locatie_toevoegen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function voegToe()
    {
      $locatie = new stdClass();

      $locatie->naam = html_escape($this->input->post('naam'));
      $locatie->straat = html_escape($this->input->post('straat'));
      $locatie->nr = html_escape($this->input->post('nr'));
      $locatie->postcode = html_escape($this->input->post('postcode'));
      $locatie->gemeente = html_escape($this->input->post('gemeente'));
      $locatie->zaal = html_escape($this->input->post('zaal'));
      $locatie->land = html_escape($this->input->post('land'));
      $locatie->extraInfo = html_escape($this->input->post('extraInfo'));
      $locatie->id = html_escape($this->input->post('id'));

      $this->load->model('locatie_model');
      $this->locatie_model->insert($locatie);

      return $this->beheren();
    }

    public function verwijder($id)
    {
        $this->load->model('locatie_model');
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['error'] = $this->locatie_model->delete($id);

        $data['titel'] = 'Locaties beheren';
        $data['persoon'] = $this->authex->getPersoonInfo();

        $data['locaties'] = $this->locatie_model->getAll();

        $partials = array(
            'inhoud' => 'trainer/locatie_beheren',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function haalJsonOp_Locaties() {
        $locatie = new stdClass();

        $locatie->naam = $this->input->get('naam');
        $locatie->straat = $this->input->get('straat');
        $locatie->nr = $this->input->get('nr');
        $locatie->postcode = $this->input->get('postcode');
        $locatie->gemeente = $this->input->get('gemeente');
        $locatie->zaal = $this->input->get('zaal');
        $locatie->land = $this->input->get('land');
        $locatie->extraInfo = $this->input->get('extraInfo');

        $this->load->model('locatie_model');
        $this->locatie_model->insert($locatie);

        $locaties = $this->locatie_model->getAll();

        echo json_encode($locaties);
    }
}
