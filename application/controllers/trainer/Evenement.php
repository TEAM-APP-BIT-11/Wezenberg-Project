<?php

/*
 * @class Evenement
 * @brief Controller-klasse voor evenementen
 * 
 * Controller-klasse met alle methodes die gebruikt worden in vervand met evenementen
 */

class Evenement extends CI_Controller
{

    /*
     * Constructor
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

    /*
     * Haalt alle evenement-records op via Evenement_model en toont de lijst in de view evenementen_beheren.php
     * 
     * @see Evenement_mode::getAll()
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

    public function laadEvenement($typeId, $isNieuw, $id = null, $isReeks = false)
    {
        $evenement = new stdClass();
        
        $data['titel'] = "Evenementen Beheren";
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
                $evenementen = $this->evenement_model->getEvenementenByEvenementReeksId($id);
                $dagen = [];
                $ids = '';
                $count = 0;
                foreach($evenementen as $reeksEvenement){
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
                $data['days'] = $dagen;
                $data['ids'] = $ids;
                $evenement = $evenementen[0];
                $laatsteEvent = $evenementen[count($evenementen) - 1];
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
        } else if(($evenement->evenementTypeId == 1 || $evenement->evenementTypeId == 4) && $hoeveelheid == 'meerdere'){
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

    private function genereerMeldingen($zwemmerIds, $evenement, $isReeks){
        $boodschap = $titel = '';
        $this->load->model('evenementtype_model');
        $type = $this->evenementtype_model->get($evenement->evenementTypeId)->type;
        if (!$isReeks) {
            if ($type == 'overige') {
                $titel = 'Nieuw evenement';
                $boodschap = 'Er is een nieuw evenement aan je schema toegevoegd: ' . $evenement->naam . '.';
            } else {
                $titel = 'Nieuwe ' . $type;
                $boodschap = 'Er is een nieuwe ' . $type . ' aan je schema toegevoegd: ' . $evenement->naam . '.';
            }
        } else {
            if ($type == 'overige') {
                $titel = 'Nieuwe evenementen';
                $boodschap = 'Er is een nieuwe reeks evenementen aan je schema toegevoegd: ' . $evenement->naam . '.';
            } else {
                $titel = 'Nieuwe trainingen';
                $boodschap = 'Er is een nieuwe reeks trainingen aan je schema toegevoegd: ' . $evenement->naam . '.';
            }
        }
        $this->melding->genereerMeldingen($zwemmerIds, $boodschap, $titel);
    }
    
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
    
    public function verwijderReeks(){
        if($this->input->post('reeksSoort') == 'trainingReeks'){
            $evenementReeksId = $this->input->post('trainingsreeksen');
        } else{
            $evenementReeksId = $this->input->post('overigereeksen');
        }
        
        $this->load->model('evenement_model');
        $evenementen = $this->evenement_model->getEvenementenByEvenementReeksId($evenementReeksId);
        
        $this->load->model('evenementdeelname_model');
        
        foreach($evenementen as $evenement){
            $deelnames = $this->evenementdeelname_model->getByEventId($evenement->id);
        
            foreach($deelnames as $deelname){
                $this->evenementdeelname_model->delete($deelname->id);
            }
            $this->evenement_model->delete($evenement->id);
        }
        
        $this->load->model('evenementreeks_model');
        $this->evenementreeks_model->delete($evenementReeksId);
        Redirect('/trainer/Evenement/beheren');
    } 
    
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
    
    public function bewerkEvenement(){ 
        $id = $this->input->post('evenementId');
        $typeId = $this->input->post('typeId');
        
        $this->laadEvenement($typeId, false, $id);
    }

    public function pasAan()
    {
        $evenement = new stdClass();

        $evenement->id = $this->input->post('evenementId');
        $evenement->naam = $this->input->post('naam');
        $evenement->locatieId = $this->input->post('locatie');
        $evenement->begindatum = $this->input->post('begindatum');
        $evenement->beginuur = $this->input->post('beginuur');
        $evenement->einduur = $this->input->post('einduur');
        $evenement->extraInfo = $this->input->post('beschrijving');
        $evenement->evenementTypeId = $this->input->post('evenementType');
        $evenement->evenementReeksId = $this->input->post('evenementReeks');

        $this->load->model('evenement_model');
        $this->evenement_model->update($evenement);

        $this->beheren();
    }
}