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
        $data['naam'] = 'Trainer x';

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
        
        $partials = array('menuGebruiker' => 'trainer_menu', 'inhoud' => 'trainer/evenement_aanpassen');
        $this->template->load('main_master', $partials, $data);
    }
}
