<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Wedstrijdaanvraag
 *
 * @author Ruben
 */
class Wedstrijdaanvraag extends CI_Controller
{
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

    public function beheren()
    {
        $data['title'] = 'Wedstrijdaanvragen beheren';
        $data['persoon'] = $this->authex->getPersoonInfo();


        $this->load->model('persoon_model');

        $this->load->model('wedstrijdreeks_model');

        $data['personen'] = $this->persoon_model->getPersoonWithDeelnamens();
        $data['alles'] = $this->wedstrijdreeks_model->getAlles();
        $partials = array(
            'inhoud' => 'trainer/Wedstrijdaanvraag_goedkeuren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }


    public function goedkeuren($deelnameId)
    {

        $this->load->model('wedstrijddeelname_model');

        $aangepaste = $this->wedstrijddeelname_model->get($deelnameId);
        $aangepaste->statusId = 2;

        $this->wedstrijddeelname_model->update($aangepaste);

        redirect('trainer/wedstrijdaanvraag/beheren');
    }

    public function afwijzen($deelnameId)
    {
        $this->load->model('wedstrijddeelname_model');

        $aangepaste = $this->wedstrijddeelname_model->get($deelnameId);
        $aangepaste->statusId = 3;

        $this->wedstrijddeelname_model->update($aangepaste);

        redirect('trainer/wedstrijdaanvraag/beheren');
    }
	public function wijzigen($id){
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['title'] = 'Wedstrijdaanvraag wijzigen';
        
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->model('wedstrijdreeks_model');
        
        $this->load->model('wedstrijddeelname_model');

        $this->load->model('wedstrijdreeks_model');

        $data['deelname'] = $this->wedstrijddeelname_model->getEnkelPersoonWithDeelnamens($id);
      
        
        $partials = array(
            'inhoud' => 'trainer/Wedstrijdaanvraag_aanpassen',
            'footer' => 'main_footer');
         
        $this->template->load('main_master', $partials, $data);
    }
    public function aanpassen(){
       
   
       
        $wedstrijdId= $this->input->post('wedstrijdId');
        $afstandId = $this->input->post('afstand');
        $slagId = $this->input->post('slag');
        
        $this->load->model('wedstrijdreeks_model');
        
        $wedstrijdreeks = $this->wedstrijdreeks_model->getWedstrijdreeks($wedstrijdId, $afstandId, $slagId);
        
        $wedstrijdDeelname = new stdClass();
        $wedstrijdDeelname->id = $this->input->post('deelnameId');
        $wedstrijdDeelname->persoonId = $this->input->post('persoonId');
        $wedstrijdDeelname->wedstrijdReeksId = $wedstrijdreeks->id;
        
        $this->load->model('wedstrijddeelname_model');
        $this->wedstrijddeelname_model->update($wedstrijdDeelname);
        redirect('trainer/wedstrijdaanvraag/beheren');
    }
    
    public function haalSlagenAfstand()
    {
        $slagId = $this->input->get('slagId');
        $wedstrijdId = $this->input->get('wedstrijdId');
        $this->load->model('wedstrijdreeks_model');
        $afstanden = $this->wedstrijdreeks_model->getAllAfstandenForSlag($slagId, $wedstrijdId);

        echo json_encode($afstanden);
    }
}
