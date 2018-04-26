<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Wedstrijd
 * @class Wedstrijd
 * @brief Controller om wedstrijdaanvragen te doen voor de zwemmer
 * @author Neil Van den Broeck
 */
class Wedstrijd extends CI_Controller
{

    function __construct()
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
     * Indexpagina gaat naar inschrijven.
     */

    public function index()
    {
        redirect('zwemmer/Wedstrijd/inschrijven');
    }

    /**
     * Haalt de informatie van de aangemelde persoon uit de Authex-library
     * Als er voor de zwemmer al een deelname voor die wedstrijdreeks bestaat dan word er geen nieuwe deelname aangemaakt (komt voor bij refreshen pagina)
     * Genereert een nieuwe deelname aan een wedstrijd voor een zwemmer met een standaard ingestelde status van 1 (= in afwachting)
     * Er wordt een melding gegenereerd voor de trainers dat er een nieuwe inschrijving is.
     * @param $wedstrijdReeksId WedstrijdreeksID waar de zwemmer voor wil inschrijven
     * @see \Wedstrijddeelname_model::insert()
     * @see \Wedstrijddeelname_model::exists()
     * @see \Wedstrijddeelname_model::getWithWedstrijdSlagAfstand()
     * @author Neil Van den Broeck
     */
    public function schrijfIn($wedstrijdReeksId)
    {
        $this->load->model("wedstrijddeelname_model");
        $this->load->model("persoon_model");
        $this->load->model("wedstrijdreeks_model");
        $persoon = $this->authex->getPersoonInfo();

        if (!($this->wedstrijddeelname_model->exists($wedstrijdReeksId, $persoon->id))) {
            $wedstrijdDeelname = new stdClass();

            $wedstrijdDeelname->persoonId = $persoon->id;
            $wedstrijdDeelname->wedstrijdReeksId = $wedstrijdReeksId;
            $wedstrijdDeelname->resultaatId = null;
            $wedstrijdDeelname->statusId = '1';
            $wedstrijdDeelname->ranking = null;

            //voegt een nieuwe record toe in de database met standaardwaardes.
            //Status op 1 = in afwachting --> standaard voor een inschrijving.
            $this->wedstrijddeelname_model->insert($wedstrijdDeelname);

            $wedstrijdreeks = $this->wedstrijdreeks_model->getWithWedstrijdSlagAfstand($wedstrijdReeksId);
            $melding = $persoon->voornaam . ' ' . $persoon->familienaam . ' heeft zich ingeschreven voor de wedstrijd: "' . $wedstrijdreeks->wedstrijd->naam . '" ' . $wedstrijdreeks->afstand->afstand . 'm ' . $wedstrijdreeks->slag->naam;

            $this->melding->genereerMeldingen($this->persoon_model->getTrainers(), $melding, 'Inschrijving voor wedstrijd');

        }
        //teruggaan naar de inschrijfpagina met de juiste reeks open
        $this->inschrijven($wedstrijdReeksId);
    }

    /**
     * Verwijdert een deelname voor een zwemmer voor een wedstrijdreeks waar hij niet langer aan wil deelnemen.
     * @author Neil Van den Broeck
     * @param $wedstrijdDeelnameId Wedstrijddeelname die uit de database moet gehaald worden.
     * @see \Wedstrijddeelname_model::delete()
     */
    public function schrijfUit($wedstrijdDeelnameId)
    {
        $this->load->model('wedstrijddeelname_model');
        $wedstrijdDeelname = $this->wedstrijddeelname_model->get($wedstrijdDeelnameId);
        // verwijderd de record uit de database met de het ID dat doorgegeven wordt

        $this->wedstrijddeelname_model->delete($wedstrijdDeelnameId);

        redirect('zwemmer/Wedstrijd/inschrijven/' . $wedstrijdDeelname->wedstrijdReeksId);
    }

    /**
     * Haalt alle wedstrijden op uit Wedstrijd_Model die in de toekomst vallen.
     * toont via wedstrijd_aanvragen deze data.
     * @author Neil Van den Broeck
     * @param int $wedstrijdId Optionele parameter om meteen de reeksen weer te geven voor een wedstrijd
     * @see wedstrijd_aanvragen.php
     * @see \Wedstrijd_model::getAllAfterToday()
     */
    public function inschrijven($wedstrijdId = 0)
    {
        $data['titel'] = 'Inschrijven voor een Wedstrijd';
        $data['eindverantwoordelijke'] = 'Neil Van den Broeck';

        $this->load->model('wedstrijd_model');

        $data['wedstrijden'] = $this->wedstrijd_model->getAllAfterToday();

        $data['tonen'] = $wedstrijdId;

        $partials = array(
            'inhoud' => 'zwemmer/wedstrijd_aanvragen',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    /** Geeft alle de wedstrijdreeksen voor een wedstrijdId via Wedstrijdreeks_model. Hier wordt een deelname aan toegevoegd indien er een is.
     *  De datum word omgezet naar een leesbare standaard.
     *  Geeft de wedstrijdreeksen via JSON terug.
     * @author Neil Van den Broeck
     * @see \Wedstrijdreeks_model::getAllFromWedstrijdSlagAfstandAndDeelnamePersoon()
     */
    public function haalJsonOp_WedstrijdReeksen()
    {
        $id = $this->input->get('wedstrijdId');

        $this->load->model('wedstrijdreeks_model');
        $persoon = $this->authex->getPersoonInfo();
        $wedstrijdreeksen = $this->wedstrijdreeks_model->getAllFromWedstrijdSlagAfstandAndDeelnamePersoon($persoon->id, $id);

        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->datum = zetOmNaarDDMMYYYY($wedstrijdreeks->datum);
        }

        echo json_encode($wedstrijdreeksen);
    }

}
