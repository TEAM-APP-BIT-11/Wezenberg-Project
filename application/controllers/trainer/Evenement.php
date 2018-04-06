<?php
/*
 * @class Evenement
 * @brief Controller-klasse voor evenementen
 * 
 * Controller-klasse met alle methodes die gebruikt worden in vervand met evenementen
 */
class Evenement extends CI_Controller {

    /*
     * Constructor
     */
    public function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /*
     * Haalt alle evenement-records op via Evenement_model en toont de lijst in de view evenementen_beheren.php
     * 
     * @see Evenement_mode::getAll()
     * @see evenementen_beheren.php
     */
    public function beheren() {
        $this->load->model('evenement_model');
        $data['evenementen'] = $this->evenement_model->getAllWithType();
        
        $this->load->model('evenementreeks_model');
        $data['evenementreeksen'] = $this->evenementreeks_model->getAll();

        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/evenementen_beheren');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function haalJsonOp_Trainingen() {
        $evenementReeksNaam = $this->input->get('evenementReeksNaam');
        
        $this->load->model('evenementreeks_model');
        $evenementReeks = $this->evenementreeks_model->getByNaam($evenementReeksNaam); 

        $this->load->model('evenement_model');
        $trainingen = $this->evenement_model->getTrainingenByEvenementReeks($evenementReeks);
        
        foreach ($trainingen as $training) {
            $training->begindatum = zetOmNaarDDMMYYYY($training->begindatum);
        }

        echo json_encode($trainingen);
    }
    
    public function bewerk(){
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
    
    public function pasAan(){
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
    
    public function nieuwEvenement($type){
        $this->load->model('persoon_model');
        $data['zwemmers'] = $this->persoon_model->getZwemmers();
        
        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();
        
        $this->load->model('evenementtype_model');
        $data['types'] = $this->evenementtype_model->getAll();

        $data['isNieuwEvenement'] = true;
        $data['type'] = $type;
        
        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/training_aanpassen');
        $this->template->load('main_master', $partials, $data);
    }
    
    public function voegNieuweTrainingenToe(){
        $evenementreeks = new stdClass();
        $evenement = new stdClass();
        
        $evenementreeks->naam = $this->input->post('naam');
        $this->load->model('evenementreeks_model');
        $evenementreeksId = $this->evenementreeks_model->insert($evenementreeks);
        
        if($this->input->post('einddatum') == null && (count($this->input->post('check_list')) == 0 || count($this->input->post('check_list')) == 1)){
            $evenement->naam = $this->input->post('naam');
            $evenement->locatieId = $this->input->post('locatie');
            $evenement->begindatum = $this->input->post('begindatum');
            $evenement->beginuur = $this->input->post('beginuur');
            $evenement->einduur = $this->input->post('einduur');
            $evenement->extraInfo = $this->input->post('beschrijving');
            $evenement->evenementTypeId = 1;
            $evenement->evenementReeksId = $evenementreeksId;
        } else if($this->input->post('einddatum') != null && count($this->input->post('check_list')) >= 1){
            $checklist = array($this->input->post('check_list[]'));
            for($date = date_create_from_format("Y-m-d", $this->input->post('begindatum')); $date <= date_create_from_format("Y-m-d", $this->input->post('einddatum')); date_add($date, date_interval_create_from_date_string('1 days'))){
                $dayOfDate = $date->format("N");
                for($i = 0; $i < count($checklist); $i++){
                    $days = $checklist[$i];
                    if(in_array($dayOfDate, $days)){
                        $evenement->naam = $this->input->post('naam');
                        $evenement->locatieId = $this->input->post('locatie');
                        $evenement->begindatum = $date->format("Y-m-d");
                        $evenement->beginuur = $this->input->post('beginuur');
                        $evenement->einduur = $this->input->post('einduur');
                        $evenement->extraInfo = $this->input->post('beschrijving');
                        $evenement->evenementTypeId = 1;
                        $evenement->evenementReeksId = $evenementreeksId;

                        $this->load->model('evenement_model');
                        $evenementId = $this->evenement_model->insert($evenement);
                    }
                }
            }
        }
    }
}
