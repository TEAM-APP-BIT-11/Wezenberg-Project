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
        $this->load->model('evenement_model');
        $data['evenementen'] = $this->evenement_model->getAllWithType();

        $this->load->model('evenementreeks_model');
        $data['evenementreeksen'] = $this->evenementreeks_model->getAll();

        $partials = array('inhoud' => 'trainer/evenementen_beheren');
        $this->template->load('main_master', $partials, $data);
    }
<<<<<<< HEAD

    public function haalJsonOp_Evenementen()
    {
        $evenementReeksNaam = $this->input->get('evenementReeksNaam');

        $this->load->model('evenementreeks_model');
        $evenementReeks = $this->evenementreeks_model->getByNaam($evenementReeksNaam);

        $this->load->model('evenement_model');
        $trainingen = $this->evenement_model->getTrainingenByEvenementReeks($evenementReeks);

=======
    
    public function haalJsonOp_Evenementen() {
        $evenementReeksId = $this->input->get('evenementReeksId');
        
        $this->load->model('evenementreeks_model');
        $evenementReeks = $this->evenementreeks_model->get($evenementReeksId); 

        $this->load->model('evenement_model');
        $trainingen = $this->evenement_model->getEvenementenByEvenementReeksId($evenementReeksId);
        
>>>>>>> evenementen beheren
        foreach ($trainingen as $training) {
            $training->begindatum = zetOmNaarDDMMYYYY($training->begindatum);
        }

        echo json_encode($trainingen);
    }

    public function nieuwEvenement($typeId)
    {
        $this->load->model('persoon_model');
        $data['zwemmers'] = $this->persoon_model->getZwemmers();

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $this->load->model('evenementtype_model');
        $evenementtype = $this->evenementtype_model->get($typeId);
        $data['types'] = $this->evenementtype_model->getAll();


        $data['isNieuwEvenement'] = true;
        $data['typeId'] = $typeId;
        $data['type'] = $evenementtype->type;
<<<<<<< HEAD

=======
       
>>>>>>> evenementen beheren
        $partials = array('inhoud' => 'trainer/evenementen_toevoegen');
        $this->template->load('main_master', $partials, $data);
    }

    public function voegNieuweEvenementenToe()
    {
        // Nieuwe lege klassen
        $evenement = new stdClass();
        $evenementreeks = new stdClass();

        $this->load->model('evenementreeks_model');

        if ($this->input->post('hoeveelheid') == 'meerdere') {
            $checklist = array($this->input->post('check_list[]'));
            for ($i = 0; $i < count($checklist); $i++) {
                $days = $checklist[$i];
            }
            $evenementreeks->naam = $this->input->post('naam');
            $evenementreeksId = $this->evenementreeks_model->insert($evenementreeks);

            for ($date = date_create_from_format("d/m/Y", $this->input->post('begindatum')); $date <= date_create_from_format("d/m/Y", $this->input->post('einddatum')); date_add($date, date_interval_create_from_date_string('1 days'))) {
                $dayOfDate = $date->format("N");
                $days;
                if (in_array($dayOfDate, $days)) {
                    // Verplichte attributen
                    $evenement->naam = $this->input->post('naam');
                    $evenement->locatieId = $this->input->post('locatie');
                    $evenement->begindatum = $date->format("Y-m-d");
                    $evenement->beginuur = $this->input->post('beginuur');
                    $evenement->evenementTypeId = $this->input->post('type');
                    // Niet-verplichte attributen
                    $evenement->einddatum = zetOmNaarYYYYMMDD($this->input->post('einddatum'));
                    if ($this->input->post('einduur') != '') {
                        $evenement->einduur = $this->input->post('einduur');
                    }
                    if ($this->input->post('beschrijving') != '') {
                        $evenement->extraInfo = $this->input->post('beschrijving');
                    }
                    $evenement->evenementReeksId = $evenementreeksId;

                    $this->load->model('evenement_model');
                    $this->evenement_model->insert($evenement);
                }
            }
            $this->genereerMeldingen($this->input->post('zwemmers'), $evenement->evenementTypeId, $evenement->naam, true);
        } else {
            // Verplichte attributen
            $evenement->naam = $this->input->post('naam');
            $evenement->locatieId = $this->input->post('locatie');
            $evenement->begindatum = zetOmNaarYYYYMMDD($this->input->post('begindatum'));
            $evenement->beginuur = $this->input->post('beginuur');
            $evenement->evenementTypeId = $this->input->post('type');
            // Niet-verplichte attributen
            if ($this->input->post('einddatum') != '') {
                $evenement->einddatum = zetOmNaarYYYYMMDD($this->input->post('einddatum'));
            }
            if ($this->input->post('einduur') != '') {
                $evenement->einduur = $this->input->post('einduur');
            }
            if ($this->input->post('beschrijving') != '') {
                $evenement->extraInfo = $this->input->post('beschrijving');
            }
            if ($evenement->evenementTypeId == 1 || $evenement->evenementTypeId == 4) {
                $evenementreeks->naam = $this->input->post('naam');
                $evenementreeksId = $this->evenementreeks_model->insert($evenementreeks);
                $evenement->evenementReeksId = $evenementreeksId;
            }
            $this->load->model('evenement_model');
            $this->evenement_model->insert($evenement);
            $this->genereerMeldingen($this->input->post('zwemmers'), $evenement->evenementTypeId, $evenement->naam, false);
        }
        Redirect('/trainer/Evenement/beheren');
    }

    private function genereerMeldingen($zwemmersLijst, $evenementType, $evenementNaam, $isReeks)
    {
        //Variabelen
        echo $zwemmersLijst;
        $zwemmerIds = array_filter(explode(',', $zwemmersLijst));
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
<<<<<<< HEAD


    public function bewerk()
    {
=======
    
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
    
    
    
    
    
    
    
    
    
    
    
    
    public function bewerk(){
>>>>>>> evenementen beheren
        $evenementId = $this->input->post('trainingsId');

        $this->load->model('evenement_model');
        $data['evenement'] = $this->evenement_model->getWithTypeLocatieDeelnamesAndPersoon($evenementId);

        $this->load->model('persoon_model');
        $data['zwemmers'] = $this->persoon_model->getZwemmers();

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $data['isNieuwEvenement'] = false;

        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/evenement_aanpassen');
        $this->template->load('main_master', $partials, $data);
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
