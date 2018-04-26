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
        
        $this->load->model('evenementreeks_model');
        $evenementReeks = $this->evenementreeks_model->get($evenementReeksId); 

        $this->load->model('evenement_model');
        $trainingen = $this->evenement_model->getEvenementenByEvenementReeksId($evenementReeksId);
        
        foreach ($trainingen as $training) {
            $training->begindatum = zetOmNaarDDMMYYYY($training->begindatum);
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
        
        var_dump($evenement);
        
        $partials = array('inhoud' => 'trainer/evenementen_toevoegen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function voegNieuweEvenementenToe()
    {
        // Nieuwe lege klassen
        $evenementReeks = new stdClass();
        
        // Attributen
        $naam = $this->input->post('naam');
        $locatieId = $this->input->post('locatie');
        $begindatum = zetOmNaarYYYYMMDD($this->input->post('begindatum'));
        if($this->input->post('einddatum') != ''){
            $einddatum = zetOmNaarYYYYMMDD($this->input->post('einddatum'));
        } else{$einddatum = null;}
        $beginuur = $this->input->post('beginuur');
        if ($this->input->post('einduur') != '') {
            $einduur = $this->input->post('einduur');
        } else{$einduur = null;}
        if ($this->input->post('beschrijving') != '') {
            $extraInfo = $this->input->post('beschrijving');
        } else{$extraInfo = null;}
        $evenementTypeId = $this->input->post('type');
        $evenementReeksId = null;
        $zwemmerIds = array_filter(explode(',', $this->input->post('zwemmers')));
        $nieuw = $this->input->post('nieuw');

        $this->load->model('evenementreeks_model');
        if ($this->input->post('hoeveelheid') == 'meerdere') {
            $checklist = array($this->input->post('check_list[]'));
            $days = [];
            for ($i = 0; $i < count($checklist); $i++) {
                $days = $checklist[$i];
            }
            $evenementReeks->naam = $naam;
            $evenementReeksId = 0;
            if(strcmp($nieuw,'false') == 0){
                $evenementIds = array_filter(explode(',', $this->input->post('ids')));
                $evenementReeksId = $this->input->post('evenementreeksId');
                $evenementReeks->id = $evenementReeksId;
                $this->evenementreeks_model->update($evenementReeks);
            } else{
                $evenementReeksId = $this->evenementreeks_model->insert($evenementReeks);
            }
            $count = 0;
            for ($date = date_create_from_format("d/m/Y", $this->input->post('begindatum')); $date <= date_create_from_format("d/m/Y", $this->input->post('einddatum')); date_add($date, date_interval_create_from_date_string('1 days'))) {
                $dayOfDate = $date->format("N");
                if (in_array($dayOfDate, $days)) {
                    if(strcmp($nieuw,'false') == 0){
                        $this->maakEvenement($naam, $locatieId, $date->format("Y-m-d"), $einddatum, $beginuur, $einduur, $extraInfo, $evenementTypeId, $evenementReeksId, $evenementIds[$count]);
                    } else{
                        $evenementId = $this->maakEvenement($naam, $locatieId, $date->format("Y-m-d"), $einddatum, $beginuur, $einduur, $extraInfo, $evenementTypeId, $evenementReeksId);
                        $this->maakEvenementDeelname($zwemmerIds, $evenementId);
                    } 
                    $count++;
                }
            }
            $this->genereerMeldingen($zwemmerIds, $evenementTypeId, $naam, true);
        } else {
            if($evenementTypeId == 1 || $evenementTypeId == 4){
                $evenementReeks->naam = $naam;
                if(strcmp($nieuw,'false') == 0){
                    $evenementReeksId = $this->input->post('evenementreeksId');
                    $evenementReeks->id = $evenementReeksId;
                    $this->evenementreeks_model->update($evenementReeks);
                } else{
                     $evenementReeksId = $this->evenementreeks_model->insert($evenementReeks);
                }
            }
            if(strcmp($nieuw,'false') == 0){
                $this->maakEvenement($naam, $locatieId, $begindatum, $einddatum, $beginuur, $einduur, $extraInfo, $evenementTypeId, $evenementReeksId, $this->input->post('id'));
            } else{
                $evenementId = $this->maakEvenement($naam, $locatieId, $begindatum, $einddatum, $beginuur, $einduur, $extraInfo, $evenementTypeId, $evenementReeksId);
                $this->genereerMeldingen($zwemmerIds, $evenementTypeId, $naam, false);
                $this->maakEvenementDeelname($zwemmerIds, $evenementId);
            } 
        }
        Redirect('/trainer/Evenement/beheren');
    }
    
    private function maakEvenement($naam, $locatieId, $begindatum, $einddatum, $beginuur, $einduur, $extraInfo, $evenementTypeId, $evenementReeksId, $evenementBestaat = 'false'){
        $evenement = new stdClass();
        
        $evenement->naam = $naam;
        $evenement->locatieId = $locatieId;
        $evenement->begindatum = $begindatum;
        $evenement->einddatum = $einddatum;
        $evenement->beginuur = $beginuur;
        $evenement->einduur = $einduur;
        $evenement->extraInfo = $extraInfo;
        $evenement->evenementTypeId = $evenementTypeId;
        $evenement->evenementReeksId = $evenementReeksId;
        
        $this->load->model('evenement_model');
        
        if(strcmp($evenementBestaat,'false') == 0){
            $evenementId = $this->evenement_model->insert($evenement);
            return $evenementId;
        } else{
            $evenement->id = $evenementBestaat;
            $this->evenement_model->update($evenement);
        }
    }
    
    private function maakEvenementDeelname($zwemmerIds, $evenementId){
        $evenementDeelname = new stdClass();
        
        $evenementDeelname->evenementId = $evenementId;
        
        $this->load->model('evenementdeelname_model');
        foreach($zwemmerIds as $zwemmerId){
            $evenementDeelname->persoonId = $zwemmerId;
            $this->evenementdeelname_model->insert($evenementDeelname);
        }
    }

    private function genereerMeldingen($zwemmerIds, $evenementType, $evenementNaam, $isReeks)
    {
        //Variabelen
        $boodschap = '';
        $titel = '';
        $this->load->model('evenementtype_model');
        $type = $this->evenementtype_model->get($evenementType)->type;
        //Titels en boodschappen genereren
        if (!$isReeks) {
            if ($evenementType == 'overige') {
                $titel = 'Nieuw evenement';
                $boodschap = 'Er is een nieuw evenement aan je schema toegevoegd: ' . $evenementNaam . '.';
            } else {
                $titel = 'Nieuwe ' . $type;
                $boodschap = 'Er is een nieuwe ' . $type . ' aan je schema toegevoegd: ' . $evenementNaam . '.';
            }
        } else {
            if ($evenementType == 'overige') {
                $titel = 'Nieuwe evenementen';
                $boodschap = 'Er is een nieuwe reeks evenementen aan je schema toegevoegd: ' . $evenementNaam . '.';
            } else {
                $titel = 'Nieuwe trainingen';
                $boodschap = 'Er is een nieuwe reeks trainingen aan je schema toegevoegd: ' . $evenementNaam . '.';
            }
        }
        $this->load->model('melding_model');
        foreach ($zwemmerIds as $zwemmerId) {
            $melding = new stdClass();
            $melding->persoonId = $zwemmerId;
            $melding->titel = $titel;
            $melding->boodschap = $boodschap;
            $melding->momentVerzonden = date("Y-m-d H:i:s");
            $melding->gelezen = 0;
            $this->melding_model->insert($melding);
        }
    }
    
    public function verwijderEvenement(){
        $evenemenId = $this->input->post('trainingsId');
        
        $this->load->model('evenementdeelname_model');
        $deelnames = $this->evenementdeelname_model->getByEventId($evenemenId);
        
        foreach($deelnames as $deelname){
            $this->evenementdeelname_model->delete($deelname->id);
        }
        
        $this->load->model('evenement_model');
        $this->evenement_model->delete($evenemenId);
        Redirect('/trainer/Evenement/beheren');
    }
    
    public function verwijderReeks(){
        if($this->input->post('reeksSoort') == 'trainingReeks'){
            $evenementReeksId = $this->input->post('trainingsreeksen');
        } else{
            $evenementReeksId = $this->input->post('overigereeksen');
        }
        
        $this->load->model('evenement_model');
        $trainingen = $this->evenement_model->getEvenementenByEvenementReeksId($evenementReeksId);
        
        foreach($trainingen as $training){
            $this->evenement_model->delete($training->id);
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
        if($this->input->post('reeksSoort') == 'trainingReeks'){
            $Id = $this->input->post('trainingsId');
            $typeId = 1;
        } else{
            $Id = $this->input->post('overigeId');
            $typeId = 4;
        }
        
        $this->laadEvenement($typeId, false, $Id);
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