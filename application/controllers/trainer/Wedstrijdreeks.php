<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wedstrijdreeks extends CI_Controller
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

    public function toevoegen($id)
    {
        $data['titel'] = 'Wedstrijd reeks toevoegen';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();

        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);

        $partials = array('inhoud' => 'trainer/wedstrijdreeks_toevoegen',
        'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function aanmaken()
    {
      $wedstrijdreeks = new stdClass();

      $wedstrijdreeks->datum = html_escape($this->input->post('reeksDatum'));
      $wedstrijdreeks->beginuur = html_escape($this->input->post('reeksBeginuur'));
      $wedstrijdreeks->einduur = html_escape($this->input->post('reeksEinduur'));
      $wedstrijdreeks->afstandId = html_escape($this->input->post('afstand'));
      $wedstrijdreeks->slagId = html_escape($this->input->post('slag'));
      $wedstrijdId = html_escape($this->input->post('id'));
      $wedstrijdreeks->wedstrijdId = $wedstrijdId;
      $this->load->model('wedstrijdreeks_model');
      $wedstrijdreeks = $this->wedstrijdreeks_model->insert($wedstrijdreeks);
      $data['id'] = $wedstrijdreeks;

      redirect('trainer/Wedstrijd/aanpassen/'. $wedstrijdId .'');
    }

    public function aanpassen($id)
    {
        $data['titel'] = 'Wedstrijd aanpassen';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijdreeks_model');
        $data['wedstrijdreeks'] = $this->wedstrijdreeks_model->getWithWedstrijd($id);

        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();

        $partials = array('inhoud' => 'trainer/wedstrijdreeks_aanpassen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function pasAan()
    {
      $wedstrijdreeks = new stdClass();

      $wedstrijdreeks->datum = html_escape($this->input->post('reeksDatum'));
      $wedstrijdreeks->beginuur = html_escape($this->input->post('reeksBeginuur'));
      $wedstrijdreeks->einduur = html_escape($this->input->post('reeksEinduur'));
      $wedstrijdreeks->afstandId = html_escape($this->input->post('afstand'));
      $wedstrijdreeks->slagId = html_escape($this->input->post('slag'));
      $wedstrijdreeks->id = html_escape($this->input->post('id'));
      $wedstrijdreeks->wedstrijdId = html_escape($this->input->post('wedstrijdId'));

      $this->load->model('wedstrijdreeks_model');
      $this->wedstrijdreeks_model->update($wedstrijdreeks);

      redirect('trainer/Wedstrijd/aanpassen/'. $wedstrijdreeks->wedstrijdId .'');
    }


    public function verwijder($id, $wedstrijdId)
    {
      $this->load->model('wedstrijdreeks_model');
      $this->wedstrijdreeks_model->delete($id);

      redirect('trainer/Wedstrijd/aanpassen/'. $wedstrijdId .'');
    }
}
