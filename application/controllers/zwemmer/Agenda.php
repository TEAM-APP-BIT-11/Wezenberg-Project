<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Agenda extends CI_Controller
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
            if ($persoon->typePersoon->typePersoon != "zwemmer") {
                redirect('Welcome/logIn');
            }
        }

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function raadplegen()
    {
        $data['titel'] = 'Agenda raadplegen';
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $partials = array('inhoud' => 'zwemmer/agenda', 'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function haalAjaxOp_Innames()
    {
        $this->load->model("inname_model");

        $persoon = $this->authex->getPersoonInfo();
        $datum = $this->input->get('datum');
        $data["innames"] = $this->inname_model->getAllByPersoonAndDate($datum, $persoon->id);


        $this->load->view('zwemmer/ajax_innames', $data);
    }

    public function haalAjaxOp_Inname()
    {
        $this->load->model("inname_model");

        $persoon = $this->authex->getPersoonInfo();
        $datum = $this->input->get('datum');
        $bestaat = $this->inname_model->existsInname($persoon->id, $datum);

        echo json_encode($bestaat);
    }

    public function haalAjaxOp_AgendaItems()
    {
// Our Start and End Dates
        $start = $this->input->get("start");
        $end = $this->input->get("end");

        $startdt = new DateTime('now'); // setup a local datetime
        $startdt->setTimestamp($start); // Set the date based on timestamp
        $start_format = $startdt->format('Y-m-d H:i:s');

        $enddt = new DateTime('now'); // setup a local datetime
        $enddt->setTimestamp($end); // Set the date based on timestamp
        $end_format = $enddt->format('Y-m-d H:i:s');


        $this->load->model('evenementdeelname_model');

        $persoon = $this->authex->getPersoonInfo();

        $evenementdeelnames = $this->evenementdeelname_model->getAllFromPersoonWithEvenement($start_format, $end_format, $persoon->id);

        $data_events = array();

        foreach ($evenementdeelnames as $evenementdeelname) {

            if ($evenementdeelname->evenement->einddatum == null) {
                $evenementdeelname->evenement->einddatum = $evenementdeelname->evenement->begindatum;
            }
            if ($evenementdeelname->evenement->einduur == null) {
                $evenementdeelname->evenement->einduur = "23:59:00";
            }

            $data_events[] = array(
                "id" => $evenementdeelname->evenement->id,
                "title" => $evenementdeelname->evenement->naam,
                "description" => $evenementdeelname->evenement->naam,
                "end" => $evenementdeelname->evenement->einddatum . ' ' . $evenementdeelname->evenement->einduur,
                "start" => $evenementdeelname->evenement->begindatum . ' ' . $evenementdeelname->evenement->beginuur
            );
        }

        echo json_encode(array("events" => $data_events));
        exit();
    }
}