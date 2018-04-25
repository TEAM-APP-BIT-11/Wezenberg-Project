<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Supplement
 *
 * @author Ruben
 */
class Supplement extends CI_Controller
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
        $data['title'] = 'supplementen beheren';

        $this->load->model('supplementdoelstelling_model');
        $this->load->model('voedingssupplement_model');
        $data['doelstellingen'] = $this->supplementdoelstelling_model->getAll();
        $data['voedingen'] = $this->voedingssupplement_model->getAllByDoelstelling(4);
        $partials = array(
            'inhoud' => 'trainer/supplementen_beheren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

    public function wijzigen()
    {
        $supplement = $this->input->post('doelstelling');
        $this->load->model('supplementdoelstelling_model');
        $uitvoeren = $this->input->post('doelstellingen');
        if ($uitvoeren == 'aanpassen') {
            if ($supplement == 0) {
                redirect('/trainer/supplement/beheren');
            } else {
                $data['title'] = 'Doelstelling wijzigen';
                $data['supplement'] = $this->supplementdoelstelling_model->get($supplement);
            }


            $partials = array(
                'inhoud' => 'trainer/doelstelling_aanpassen',
                'footer' => 'main_footer');
        } elseif ($uitvoeren == 'toevoegen') {
            $data['title'] = 'Doelstelling toevoegen';
            $partials = array(
                'inhoud' => 'trainer/doelstelling_toevoegen',
                'footer' => 'main_footer');
        } elseif ($uitvoeren == 'verwijderen') {
            $this->load->model('voedingssupplement_model');
            $this->voedingssupplement_model->verwijderAlleSupplementen($supplement);
            $this->supplementdoelstelling_model->delete($supplement);
            redirect('/trainer/supplement/beheren');
        }

        $this->template->load('main_master', $partials, $data);
    }

    public function haalVoedingProducten()
    {
        $doelstellingId = $this->input->get('doelstellingId');

        $this->load->model('voedingssupplement_model');
        $voedingen = $this->voedingssupplement_model->getAllByDoelstelling($doelstellingId);

        echo json_encode($voedingen);
    }

    public function opslaan()
    {
        $doelstelling = new stdClass();
        $doelstelling->id = $this->input->post('doelstellingId');
        $doelstelling->doelstelling = $this->input->post('doelstelling');


        $this->load->model('supplementdoelstelling_model');

        $this->supplementdoelstelling_model->update($doelstelling);


        redirect('trainer/supplement/beheren');
    }

    public function toevoegen()
    {
        $doelstelling = new stdClass();
        $doelstelling->id = $this->input->post('doelstellingId');
        $doelstelling->doelstelling = $this->input->post('doelstelling');

        $this->load->model('supplementdoelstelling_model');

        $this->supplementdoelstelling_model->insert($doelstelling);

        redirect('trainer/supplement/beheren');
    }

    public function supplementVerandering()
    {
        $supplement = $this->input->post('supplementen');

        $this->load->model('supplementdoelstelling_model');
        $this->load->model('voedingssupplement_model');
        $uitvoeren = $this->input->post('supplement');
        if ($uitvoeren == 'aanpassen') {
            if ($supplement == 0) {
                redirect('/trainer/supplement/beheren');
            } else {
                $data['title'] = 'Supplement wijzigen';
                $data['supplement'] = $this->voedingssupplement_model->getWithDoelstelling($supplement);
            }


            $partials = array(
                'inhoud' => 'trainer/supplement_aanpassen',
                'footer' => 'main_footer');
        } elseif ($uitvoeren == 'toevoegen') {
            $data['title'] = 'Supplement toevoegen';
            $data['doelstellingen'] = $this->supplementdoelstelling_model->getAll();
            $partials = array(
                'inhoud' => 'trainer/supplement_toevoegen',
                'footer' => 'main_footer');
        } elseif ($uitvoeren == 'verwijderen') {
            $this->voedingssupplement_model->delete($supplement);
            redirect('/trainer/supplement/beheren');
        }

        $this->template->load('main_master', $partials, $data);
    }

    public function voedingOpslaan()
    {
        $supplement = new stdClass();
        $supplement->id = $this->input->post('supplementId');
        $supplement->doelstellingId = $this->input->post('doelstellingId');
        $supplement->naam = $this->input->post('voedingssupplement');


        $this->load->model('voedingssupplement_model');

        $this->voedingssupplement_model->update($supplement);


        redirect('trainer/supplement/beheren');
    }

    public function supplementToevoegen()
    {
        $supplement = new stdClass();
        $supplement->id = $this->input->post('voedingId');
        $supplement->naam = $this->input->post('supplement');
        $supplement->doelstellingId = $this->input->post('doelstelling');

        $this->load->model('voedingssupplement_model');

        $this->voedingssupplement_model->insert($supplement);

        redirect('trainer/supplement/beheren');
    }
}
