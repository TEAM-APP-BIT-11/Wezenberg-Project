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
        
        $partials = array(
            'inhoud' => 'trainer/Wedstrijdaanvraag_aanpassen',
            'footer' => 'main_footer');
         
        $this->template->load('main_master', $partials, $data);
    }
}
