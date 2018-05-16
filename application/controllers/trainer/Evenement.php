<?php

/**
 * @class Evenement
 * @brief Controller-klasse voor evenementen
 * 
 * Controller-klasse met alle methodes die gebruikt worden in verband met evenementen
 */

class Evenement extends CI_Controller
{

    /**
     * Constructor
     */
    
    public function __construct()
    {
        parent::__construct();

        if (!$this->authex->isAangemeld()) {
            redirect('Algemeen/logIn');
        } else {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->typePersoon->typePersoon !== "trainer") {
                redirect('');
            }
        }

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /**
     * Haalt alle evenement-records inclusief type op via Evenement_model, alle evenementreeksen via Evenementreeks_model en toont de view evenementen_beheren.php die deze data gebruikt.
     * 
     * @author Senne Cools
     * @see Evenement_model::getAllWithType()
     * @see Evenementreeks_model::getAll()
     * @see evenementen_beheren.php
     */
    
    public function beheren()
    {
        $data['titel'] = "Evenementen Beheren";
        $data['eindverantwoordelijke'] = "Senne Cools";
        $this->load->model('evenement_model');
        $data['evenementen'] = $this->evenement_model->getAllWithType();

        $this->load->model('evenementreeks_model');
        $data['evenementreeksen'] = $this->evenementreeks_model->getAll();

        $partials = array('inhoud' => 'trainer/evenementen_beheren', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Haalt alle evenement-records op via Evenement_model die bij de gegeven evenementReeksId=$evenementReeksId horen en stuurt die via json terug naar de view evenementen_beheren.php.
     * 
     * @author Senne Cools
     * @param evenementReeksId De id van de evenementreeks van de opgevraagde evenementen.
     * @see Evenement_model::getEvenementenByEvenementReeksId()
     * @see evenementen_beheren.php
     */
    
    public function haalJsonOp_Evenementen() {
        $evenementReeksId = $this->input->get('evenementReeksId'); 

        $this->load->model('evenement_model');
        $trainingen = $this->evenement_model->getEvenementenByEvenementReeksId($evenementReeksId);
        
        foreach ($trainingen as $training) {
            $training->begindatum = zetOmNaarDDMMYYYY($training->begindatum);
            $training->beginuur = zetOmNaarHHMM($training->beginuur);
            if($training->einduur != null){$training->einduur = zetOmNaarHHMM($training->einduur);}
        }

        echo json_encode($trainingen);
    }

    /**
     * Laadt afhankelijk van de waarde van de meegegeven waarden een leeg evenement of een bestaand evenement. Dit evenement wordt samen met het bijhorend type, deelnemers en locaties doorgestuurd naar de view evenementen_toevoegen.php.
     * 
     * @author Senne Cools
     * @param typeId De id die aangeeft van welk type het evenement dat geladen wordt is.
     * @param $isNieuw De waarde van deze boolean bepaalt of er een nieuw of een bestaand evenement geladen moet worden.
     * @param $id Als $isNieuw false is geeft deze id aan welk evenement geladen moet worden. 
     * @param $isReeks De waarde van deze boolean bepaalt of er een enkel evenement of een reeks geladen moet worden.
     * @see Persoon_model::getZwemmers()
     * @see Locatie_model::getAll()
     * @see Evenementtype_model::get()
     * @see Evenementtype_model::getAll()
     * @see Evenement_model::getEvenementenByEvenementReeksId()
     * @see Evenementdeelname_model::getByEventId()
     * @see evenementen_toevoegen.php
     */
    
    public function laadEvenement($typeId, $isNieuw, $id = null, $isReeks = false)
    {
        $evenement = new stdClass();
        
        $data['titel'] = "Evenementen Toevoegen";
        $data['eindverantwoordelijke'] = "Senne Cools";
        
        $this->load->model('persoon_model');
        $data['zwemmers'] = $this->persoon_model->getZwemmers();

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $this->load->model('evenementtype_model');
        $data['evenementtype'] = $this->evenementtype_model->get($typeId);
        $data['types'] = $this->evenementtype_model->getAll();       

        $data['isNieuw'] = $isNieuw;
        $data['isReeks'] = $isReeks;
        
        if(!$isNieuw){
            $this->load->model('evenement_model');
            $this->load->model('evenementdeelname_model');
            if($isReeks){
                $evenementenInReeks = $this->evenement_model->getEvenementenByEvenementReeksId($id);
                $gegevens = $this->haalDagenVanReeksOp($evenementenInReeks);
                $data['days'] = $gegevens[0];
                $data['ids'] = $gegevens[1];
                $evenementDeelnames = $gegevens[2];
                $evenement = $evenementenInReeks[0];
                $laatsteEvent = $evenementenInReeks[count($evenementenInReeks) - 1];
                $evenement->einddatum = $laatsteEvent->begindatum;

            } else{
                $evenement = $this->evenement_model->get($id);
                $evenementDeelnames = $this->evenementdeelname_model->getByEventId($id);
                $data['id'] = $id;
            }
            $data['evenement'] = $evenement;
            $deelnemendeZwemmers = [];
            foreach($evenementDeelnames as $evenementDeelname){
                $deelnemendeZwemmer = $this->persoon_model->get($evenementDeelname->persoonId);
                array_push($deelnemendeZwemmers, $deelnemendeZwemmer);
            }
            $data['deelnemendeZwemmers'] = $deelnemendeZwemmers;
        }
        
        $partials = array('inhoud' => 'trainer/evenementen_toevoegen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Voegt nieuwe evenementen toe aan de database via Evenement_model.php. Alle vereiste waarden worden door de gebruiker in de view evenementen_toevoegen.php ingevoerd. Afhankelijk van de ingevoerde waarden wordt een enkel evenement of een reeks evenementen toegevoegd.
     * 
     * @author Senne Cools
     * @see Evenementreeks_model::update()
     * @see Evenementreeks_model::insert()
     * @see <genereerReeks>
     * @see <maakEvenement>
     * @see <genereerMeldingen>
     * @see <maakEvenementDeelname>
     * @see evenementen_beheren.php
     */
    
    public function voegNieuweEvenementenToe()
    {
        // Nieuwe lege klassen
        $evenementReeks = new stdClass();
        $evenement = new stdClass();
        
        // Attributen
        $evenement->naam = $evenementReeks->naam = $this->input->post('naam');
        $evenement->locatieId = $this->input->post('locatie');
        $evenement->begindatum = zetOmNaarYYYYMMDD($this->input->post('begindatum'));
        if($this->input->post('einddatum') != ''){
            $evenement->einddatum = zetOmNaarYYYYMMDD($this->input->post('einddatum'));
        } else{$evenement->einddatum = null;}
        $evenement->beginuur = $this->input->post('beginuur');
        if ($this->input->post('einduur') != '') {
            $evenement->einduur = $this->input->post('einduur');
        } else{$evenement->einduur = null;}
        if ($this->input->post('beschrijving') != '') {
            $evenement->extraInfo = $this->input->post('beschrijving');
        } else{$evenement->extraInfo = null;}
        $evenement->evenementTypeId = $this->input->post('type');
        $evenement->evenementReeksId = null;
        
        $zwemmerIds = $this->input->post('zwemmers');
        $nieuw = $this->input->post('nieuw');
        $hoeveelheid = $this->input->post('hoeveelheid');

        $this->load->model('evenementreeks_model');
        
        if(strcmp($nieuw, 'false') == 0 && ($evenement->evenementTypeId == 1 || $evenement->evenementTypeId == 4)){
            $evenement->evenementReeksId = $evenementReeks->id = $this->input->post('evenementreeksId');
            if($hoeveelheid == 'meerdere'){
                $this->evenementreeks_model->update($evenementReeks);
            }
        } else if($evenement->evenementTypeId == 1 || $evenement->evenementTypeId == 4){
            $evenement->evenementReeksId = $this->evenementreeks_model->insert($evenementReeks);
        }
        
        if ($hoeveelheid == 'meerdere') {
            $checklist = array($this->input->post('check_list[]'));
            $days = [];
            for ($i = 0; $i < count($checklist); $i++) {
                $days = $checklist[$i];
            }
            if(strcmp($nieuw, 'false') == 0){
                $evenementIds = array_filter(explode(',', $this->input->post('ids')));
                $this->genereerReeks($zwemmerIds, $evenement, $days, false, $evenementIds);
            } else{
                $this->genereerReeks($zwemmerIds, $evenement, $days, true);
            }
        } else {
            if(strcmp($nieuw,'false') == 0){
                $this->maakEvenement($evenement, $this->input->post('id'));
            } else{
                $evenementId = $this->maakEvenement($evenement);
                $this->genereerMeldingen($zwemmerIds, $evenement, false);
                $this->maakEvenementDeelname($zwemmerIds, $evenementId);
            } 
        }
        Redirect('/trainer/Evenement/beheren');
    }
    
    /**
     * Haalt de dagen op waarop een evenementreeks doorgaat die nodig zijn om de evenementreeks te laden.
     * 
     * @author Senne Cools
     * @param $evenementenInReeks Een array die de evenementen van de evenementreeks bevat.
     * @see Evenementdeelname_model::getByEventId()
     */
    
    private function haalDagenVanReeksOp($evenementenInReeks){
        $ids = "";
        $dagen = [];
        $count = 0;
        foreach($evenementenInReeks as $reeksEvenement){
            $ids .= strval($reeksEvenement->id) . ",";
            if($count == 0){
                $evenementDeelnames = $this->evenementdeelname_model->getByEventId($reeksEvenement->id);
            }
            $sqldag = date_create_from_format("Y-m-d", $reeksEvenement->begindatum);
            $dag = $sqldag->format("N");
            if(!in_array($dag, $dagen)){
                array_push($dagen, $dag);
            }
            $count++;
        }
        $gegevens = [];
        array_push($gegevens, $dagen, $ids, $evenementDeelnames);
        return $gegevens;
    }
    
    /**
     * Genereert een reeks met bijhorende evenementen, deelnames en meldingen op basis van de opgegeven waarden.
     * 
     * @author Senne Cools
     * @param $zwemmerIds Een array die de evenementen van de evenementreeks bevat.
     * @param $evenement Het evenement waarop de reeks gebaseerd zal worden.
     * @param $days De dagen waarom de reeks doorgaat.
     * @param $nieuw Afhankelijk van deze waarde van deze boolean gaat het systeem een overeenkomstige bestaande reeks zoeken verwijderen of niet.
     * @param $evenementIds De ids van de evenementen in de reeks, als de reeks al bestaat.
     * @see <verwijderEvenement>
     * @see <maakEvenement>
     * @see <maakEvenementDeelname>
     * @see <genereerMeldingen>
     */
    
    private function genereerReeks($zwemmerIds, $evenement, $days, $nieuw, $evenementIds = []){
        if(!$nieuw && !empty($evenementIds)){
            foreach($evenementIds as $evenementId){
                $this->verwijderEvenement($evenementId);
            }
        }
        $einddatum = date_create_from_format('Y-m-d', $evenement->einddatum);
        $evenement->einddatum = null;
        for ($date = date_create_from_format('Y-m-d', $evenement->begindatum); $date <= $einddatum; date_add($date, date_interval_create_from_date_string('1 days'))) {
            $dayOfDate = $date->format("N");
            if (in_array($dayOfDate, $days)) {
                $evenement->begindatum = $date->format("Y-m-d");
                $evenementId = $this->maakEvenement($evenement);
                $this->maakEvenementDeelname($zwemmerIds, $evenementId); 
            }
        }
        
        $this->genereerMeldingen($zwemmerIds, $evenement, true);
    }
    
    /**
     * Voegt een evenement toe of update een evenement afhankelijk van de waarde van de variabele nieuw=$nieuw.
     * 
     * @author Senne Cools
     * @param $evenement Het evenement dat toegevoegd op geüpdate moet worden.
     * @param $nieuw De waarde van deze boolean bepaalt of het evenement toegevoegd of geüpdate moet worden.
     * @see Evenement_model::insert()
     * @see Evenement_model::update()
     */
    
    private function maakEvenement($evenement, $nieuw = 'false'){       
        $this->load->model('evenement_model');
        
        if(strcmp($nieuw, 'false') == 0){
            $evenementId = $this->evenement_model->insert($evenement);
            return $evenementId;
        } else{
            $evenement->id = $nieuw;
            $this->evenement_model->update($evenement);
        }
    }
    
    /**
     * Voegt voor elke zwemmer die bij de meegegeven zwemmerIds=$zwemmerIds hoort een deelname toe in de database voor het evenement dat bij de meegegeven evenementId=$evenementId hoort.
     * 
     * @author Senne Cools
     * @param $zwemmerIds De ids's van de zwemmers waarvoor een melding toegevoegd moet worden.
     * @param $evenementId De id van het evenement waarvoor meldingen gemaakt moeten worden.
     * @see Evenementdeelname_model::insert()
     */
    
    private function maakEvenementDeelname($zwemmerIds, $evenementId){
        $evenementDeelname = new stdClass();
        
        $evenementDeelname->evenementId = $evenementId;
        
        $this->load->model('evenementdeelname_model');
        $ids = array_filter(explode(',', $zwemmerIds));
        foreach($ids as $zwemmerId){
            $evenementDeelname->persoonId = $zwemmerId;
            $this->evenementdeelname_model->insert($evenementDeelname);
        }
    }
    
    /**
     * Genereert voor de zwemmers die bij de meegegeven zwemmerIds=$zwemmerIds de juiste boodschap voor een melding voor het aangemaakte evenement=$evenement
     * 
     * @author Senne Cools
     * @param $zwemmerIds De ids's van de zwemmers waarvoor een melding toegevoegd moet worden.
     * @param $evenement Het evenement waarvoor een melding toegevoegd moet worden.
     * @param $isReeks Deze parameter geeft aan of de boodschap voor een reeks is of niet.
     * @see Evenementtype_model::get()
     * @see Melding::genereerMeldingen()
     */

    private function genereerMeldingen($zwemmerIds, $evenement, $isReeks){
        $boodschap = $titel = '';
        $this->load->model('evenementtype_model');
        $type = $this->evenementtype_model->get($evenement->evenementTypeId)->type;
        if (!$isReeks) {
            if ($type == 'overig') {
                $titel = 'Nieuw evenement';
                $boodschap = 'Er is een nieuw evenement aan je schema toegevoegd: ' . $evenement->naam . '.';
            } else {
                $titel = 'Nieuwe ' . $type;
                $boodschap = 'Er is een nieuwe ' . $type . ' aan je schema toegevoegd: ' . $evenement->naam . '.';
            }
        } else {
            if ($type == 'overig') {
                $titel = 'Nieuwe evenementen';
                $boodschap = 'Er is een nieuwe reeks evenementen aan je schema toegevoegd: ' . $evenement->naam . '.';
            } else {
                $titel = 'Nieuwe trainingen';
                $boodschap = 'Er is een nieuwe reeks trainingen aan je schema toegevoegd: ' . $evenement->naam . '.';
            }
        }
        $this->melding->genereerMeldingen($zwemmerIds, $boodschap, $titel);
    }
    
    /**
     * Verwijdert het evenement met bijhorende deelnames dat bij de opgegeven evementId=$evenementId hoort.
     * 
     * @author Senne Cools
     * @param $evenementId De id van het evenement dat verwijderd moet worden
     * @see Evenementdeelname_model::getByEventId()
     * @see Evenementdeelname_model::delete()
     * @see Evenement_model::delete()
     */
    
    public function verwijderEvenement($evenementId = 0){
        $internCommando = false;
        if($evenementId == 0){
            $evenementId = $this->input->post('evenementId');
        } else{
            $internCommando = true;
        }
        
        $this->load->model('evenementdeelname_model');
        $deelnames = $this->evenementdeelname_model->getByEventId($evenementId);
        
        foreach($deelnames as $deelname){
            $this->evenementdeelname_model->delete($deelname->id);
        }
        
        $this->load->model('evenement_model');
        $this->evenement_model->delete($evenementId);
        
        if(!$internCommando){
            Redirect('/trainer/Evenement/beheren');
        }
    }
    
    /**
     * Verwijdert de evenementreeks met bijhorende evenementen dat bij de opgegeven evenementReeksId=$evenementReeksId hoort.
     * 
     * @author Senne Cools
     * @param $evenementReeksId De id van de evenementreeks die verwijderd moet worden
     * @see Evenement_model::getEvenementenByEvenementReeksId()
     * @see <verwijderEvenement>
     * @see Evenementreeks_model::delete()
     */
    
    public function verwijderReeks(){
        if($this->input->post('reeksSoort') == 'trainingReeks'){
            $evenementReeksId = $this->input->post('trainingsreeksen');
        } else{
            $evenementReeksId = $this->input->post('overigereeksen');
        }
        
        $this->load->model('evenement_model');
        $evenementen = $this->evenement_model->getEvenementenByEvenementReeksId($evenementReeksId);
        
        foreach($evenementen as $evenement){
            $this->verwijderEvenement($evenement->id);
        }
        
        $this->load->model('evenementreeks_model');
        $this->evenementreeks_model->delete($evenementReeksId);
        Redirect('/trainer/Evenement/beheren');
    } 
    
    /**
     * Laadt een reeks om te bewerken, en differentieert bij het laden tussen een trainingreeks en een overige reeks.
     * 
     * @author Senne Cools
     * @see <laadEvenement>
     */
    
    public function bewerkReeks(){
        if($this->input->post('reeksSoort') == 'trainingReeks'){
            $evenementReeksId = $this->input->post('trainingsreeksen');
            $typeId = 1;
        } else{
            $evenementReeksId = $this->input->post('overigereeksen');
            $typeId = 4;
        }
        
        $this->laadEvenement($typeId, false, $evenementReeksId, true);
    }
    
    /**
     * Laadt een evenement om te bewerken.
     * 
     * @author Senne Cools
     * @see <laadEvenement>
     */
    
    public function bewerkEvenement(){ 
        $id = $this->input->post('evenementId');
        $typeId = $this->input->post('typeId');
        
        $this->laadEvenement($typeId, false, $id);
    }
}