<?php

/**
 * Class Agenda
 * @class Agenda
 * @brief Controller-klasse met de benodigde methodes die gebruikt worden om de Agenda voor de zwemmer/trainer te voorzien.
 * @author Neil Van den Broeck
 */

class Agenda extends CI_Controller
{
    /**
     * Agenda constructor.
     * Indien de persoon niet is aangemeld wordt deze naar de loginpagina gestuurd.
     * Agenda kan zowel als trainer en zwemmer worden opgeroepen.
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->authex->isAangemeld()) {
            redirect('Algemeen/logIn');
        }
        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /**
     * Haalt de aangemelde persoon uit de Authex-library.
     * Haalt de innames voor de aangemelde persoon binnen en zet de datums in een array.
     * Haalt agendaitems op voor ene persoon en stuurt deze als json door naar de view
     * @see zwemmer/agenda.php
     * @see Inname_model::getAllFromPersoon()
     * @see \Authex::getPersoonInfo()
     * @see \Agenda::agendaItems()
     * @author Neil Van den Broeck
     */
    public function raadplegen($id = -1)
    {
        //zwemmers kunnen enkel hun eigen agenda bekijken. Dus als het een zwemmer is (type == 2) dan wordt $id de id van de ingelogde persoon.
        $persoon = $this->authex->getPersoonInfo();
        if ($persoon->typePersoonId == 2) {
            $id = $persoon->id;
        }
        $data['titel'] = 'Agenda raadplegen';
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        $this->load->model('inname_model');
        $innames = $this->inname_model->getAllFromPersoon($id);

        //Datums van de innames in een array plaatsen.
        $innamesarray = array();
        foreach ($innames as $inname) {
            array_push($innamesarray, $inname->datum);
        }
        $data['innames'] = json_encode($innamesarray);

        //agendaitems ophalen
        $data['datums'] = $this->agendaItems($id);

        $this->load->model('persoon_model');
        $data['zwemmer'] = $this->persoon_model->get($id);

        $partials = array('inhoud' => 'zwemmer/agenda', 'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     *
     * Krijgt van de functie de datum mee waarvoor de voedingssuplementen moeten worden ingenomen.
     * Alsook de persoonId waarvoor de innames moeten worden opgehaald.
     * Geeft de in te nemen innames van voedingssupplementen weer in een tabel.
     * en stuurt deze door naar de view.
     * @author Neil Van den Broeck
     * @see \Inname_model::getAllByPersoonAndDate()
     * @see \Authex::getPersoonInfo()
     * @see zwemmer/ajax_innames
     */
    public function haalAjaxOp_Innames()
    {
        $this->load->model("inname_model");

        $datum = $this->input->get('datum');
        $persoonId = $this->input->get('persoonId');

        $data["innames"] = $this->inname_model->getAllByPersoonAndDateWithVoedingssupplement($datum, $persoonId);

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
            if ($wedstrijddeelname->wedstrijdreeks->wedstrijd->einddatum == null) {
                $wedstrijddeelname->wedstrijdreeks->wedstrijd->einddatum = $wedstrijddeelname->wedstrijdreeks->wedstrijd->begindatum;
            }

            $data_events[] = array(
                "id" => $wedstrijddeelname->wedstrijdreeks->wedstrijd->id,
                "title" => $wedstrijddeelname->wedstrijdreeks->wedstrijd->naam,
                "description" => $wedstrijddeelname->wedstrijdreeks->wedstrijd->naam . ', u bent ingeschreven voor de reeks ' . $wedstrijddeelname->wedstrijdreeks->afstand->afstand . 'm ' . $wedstrijddeelname->wedstrijdreeks->slag->naam . ' om ' . zetOmNaarHHMM($wedstrijddeelname->wedstrijdreeks->beginuur),
                "end" => $wedstrijddeelname->wedstrijdreeks->wedstrijd->einddatum . ' ' . "23:59:00",
                "start" => $wedstrijddeelname->wedstrijdreeks->wedstrijd->begindatum . ' ' . "00:00:00",
                "locatie" => $wedstrijddeelname->wedstrijdreeks->wedstrijd->locatie->naam,
                "locatieId" => $wedstrijddeelname->wedstrijdreeks->wedstrijd->locatieId,
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
                "locatie" => $evenementdeelname->evenement->locatie->naam,
                "locatieId" => $evenementdeelname->evenement->locatieId,
                "color" => $kleuren[($evenementdeelname->evenement->evenementTypeId - 1)]
            );
        }

        return json_encode($data_events);
    }

    /**
     * @param locatieId De id van de locatie waarvan de gegevens moeten opgehaald worden.
     * Geeft de gegevens van een locatie weer.
     * @return locatiegegevens van die locatie.
     * @see ajax_locatie.php
     * @see locatie_model::get()
     * @author Dieter Verboven
     */

    public function haalLocatieOp()
    {
        $id = $this->input->get('id');

        $this->load->model("locatie_model");

        $data["locatie"] = $this->locatie_model->get($id);

        $this->load->view('zwemmer/ajax_locatie', $data);
    }


    /**
     * redirect naar de functie raadplegen
     * @see raadplegen();
     */
    public function index()
    {
        redirect("zwemmer/Agenda/raadplegen");
    }
}