<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of supplementschema
 *
 * @author Ruben
 */
class Supplementschema extends CI_Controller {
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
        $this->load->helper('date');
    }

    public function beheren(){
        $data['title'] = 'Schema van de supplementen';
        $data['persoon'] = $this->authex->getPersoonInfo();


          $this->load->model('persoon_model');

          $this->load->model('inname_model');
         $data['personen']=$this->persoon_model->getPersoonWithInnames();
          $data['innames']=$this->inname_model->getInnamesPersonen();


           $partials = array(
            'inhoud' => 'trainer/supplementen_schema_beheren');
        $this->template->load('main_master', $partials, $data);
    }

    public function toevoegen(){
        $data['title'] = 'Supplement toevoegen aan een zwemmer';
        $this->load->model('persoon_model');

          $this->load->model('voedingssupplement_model');
         $data['personen']=$this->persoon_model->getAll();
          $data['innames']=$this->voedingssupplement_model->getAll();

           $partials = array(
            'inhoud' => 'trainer/supplement_trainer_toevoegen');
        $this->template->load('main_master', $partials, $data);
    }

    public function opslaan(){
           $datum = $this->input->post('datums');
            $this->load->model('inname_model');
           foreach($datum as $date){
                $inname = new stdClass();
                $inname->id = 0;
            $inname->persoonId = $this->input->post('personen');
            $inname->voedingssupplementId = $this->input->post('supplementen');
             $inname->aantal = $this->input->post('aantal');
             $inname->datum = DateTime::createFromFormat('m/d/Y',$date)->format('Y-m-d');

             $inname->innameReeksId = 1;
             $this->inname_model->insert($inname);
           }


            redirect('trainer/supplementschema/beheren');
    }

    public function aanpassen($id){

          $data['title'] = 'Supplement aanpassen';
          $this->load->model('inname_model');
          $this->load->model('persoon_model');
          $this->load->model('voedingssupplement_model');
          $data['inname']=$this->inname_model->getWithPersoon($id);
          $data['persoon'] = $this->persoon_model->get($data['inname']->persoonId);
          $data['innames'] = $this->voedingssupplement_model->getAll();


           $partials = array(
            'inhoud' => 'trainer/supplement_aanpassen_in_schema');
        $this->template->load('main_master', $partials, $data);
    }

    public function aangepast(){
        $datum = $this->input->post('datums');
        $this->load->model('inname_model');
        foreach($datum as $date){
        $inname = new stdClass();
                $inname->id = $this->input->post('id');
            $inname->persoonId = $this->input->post('persoonId');
            $inname->voedingssupplementId = $this->input->post('supplementen');
             $inname->aantal = $this->input->post('aantal');
             $inname->datum = DateTime::createFromFormat('m/d/Y',$date)->format('Y-m-d');

             $inname->innameReeksId = $this->input->post('innameReeksId');
              $this->inname_model->update($inname);
        }
               redirect('trainer/supplementschema/beheren');
    }

    public function verwijderen($id){
        $this->load->model('inname_model');

        $this->inname_model->delete($id);
            redirect('/trainer/supplementschema/beheren');
    }
}
