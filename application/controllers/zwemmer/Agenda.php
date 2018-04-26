<?php

/**
 * Class Agenda
 * @class Agenda
 * @brief Controller-klasse met de benodigde methodes die gebruikt worden om de Agenda voor de zwemmer te voorzien.
 * @author Neil Van den Broeck
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

    /**
     * Haalt de aangemelde persoon uit de Authex-library.
     * Haalt de innames voor de aangemelde persoon binnen en zet de datums in een array.
     * Haalt agendaitems op en stuurt deze door naar de view
     * @see zwemmer/agenda.php
     * @see Inname_model::getAllFromPersoon()
     * @author Neil Van den Broeck
     */
    public function raadplegen()
    {
        $data['titel'] = 'Agenda raadplegen';
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        $persoon = $this->authex->getPersoonInfo();
        $this->load->model('inname_model');

        $innames = $this->inname_model->getAllFromPersoon($persoon->id);

        $innamesarray = array();
        foreach ($innames as $inname) {
            array_push($innamesarray, $inname->datum);
        }
        $data['innames'] = json_encode($innamesarray);

        $data['datums'] = $this->agendaItems($persoon->id);

        $partials = array('inhoud' => 'zwemmer/agenda', 'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt de aangemelde persoon uit de Authex-library.
     * Krijgt van de functie de datum mee waarvoor de voedingssuplementen moeten worden ingenomen.
     * Geeft de in te nemen innames van voedingssupplementen weer in een tabel.
     * @author Neil Van den Broeck
     * @see \Inname_model::getAllByPersoonAndDate()
     * @see zwemmer/ajax_innames
     */
    public function haalAjaxOp_Innames()
    {
        $this->load->model("inname_model");

        $persoon = $this->authex->getPersoonInfo();
        $datum = $this->input->get('datum');
        $data["innames"] = $this->inname_model->getAllByPersoonAndDateWithVoedingssupplement($datum, $persoon->id);

        $this->load->view('zwemmer/ajax_innames', $data);
    }

    /**
     * @param $persoonId De van de persoon waarvan de gegevens moeten opgehaald worden.
     * Geeft de agenda-items van een persoon weer die weergegeven worden in de Agenda voor de zwemmer.
     * @return JSON-array met de evenementen en wedstrijden voor een persoon.
     * @see agenda.php
     * @see Evenementdeelname_model::getAllFromPersoonWithEvenement
     * @see Wedstrijddeelname_model::getAllByPersoonAndStatus2WithWedstrijd
     * @author Neil Van den Broeck
     */
    public function agendaItems($persoonId)
    {
        $this->load->model('evenementdeelname_model');
        $this->load->model('wedstrijddeelname_model');


        $evenementdeelnames = $this->evenementdeelname_model->getAllFromPersoonWithEvenement($persoonId);
        $wedstrijddeelnames = $this->wedstrijddeelname_model->getAllByPersoonAndStatus2WithWedstrijd($persoonId);

        $data_events = array();

        foreach ($wedstrijddeelnames as $wedstrijddeelname) {
            if ($wedstrijddeelname->wedstrijd->einddatum == null) {
                $wedstrijddeelname->wedstrijd->einddatum = $wedstrijddeelname->wedstrijd->begindatum;
            }

            $data_events[] = array(
                "id" => $wedstrijddeelname->wedstrijd->id,
                "title" => $wedstrijddeelname->wedstrijd->naam,
                "description" => $wedstrijddeelname->wedstrijd->naam,
                "end" => $wedstrijddeelname->wedstrijd->einddatum . ' ' . "23:59:00",
                "start" => $wedstrijddeelname->wedstrijd->begindatum . ' ' . "00:00:00",
                "locatie" => $wedstrijddeelname->wedstrijd->locatie->naam,
                "color" => "green"
            );
        }

        foreach ($evenementdeelnames as $evenementdeelname) {

            if ($evenementdeelname->evenement->einddatum == null) {
                $evenementdeelname->evenement->einddatum = $evenementdeelname->evenement->begindatum;
            }
            if ($evenementdeelname->evenement->einduur == null) {
                $evenementdeelname->evenement->einduur = "23:59:00";
            }

            $kleuren = array('blue', 'hotpink', 'red', 'purple');

            $data_events[] = array(
                "id" => $evenementdeelname->evenement->id,
                "title" => $evenementdeelname->evenement->naam,
                "description" => $evenementdeelname->evenement->naam,
                "end" => $evenementdeelname->evenement->einddatum . ' ' . $evenementdeelname->evenement->einduur,
                "start" => $evenementdeelname->evenement->begindatum . ' ' . $evenementdeelname->evenement->beginuur,
                "locatie" => $evenementdeelname->evenement->locatieId,
                "color" => $kleuren[$evenementdeelname->evenement->evenementTypeId]
            );
        }

        return json_encode($data_events);
    }
}