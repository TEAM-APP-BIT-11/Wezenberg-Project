<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Contact extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function index()
    {
        $data['titel'] = 'Contacteer';
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        $partials = array(
            'inhoud' => 'trainer/home',
            'footer' => 'main_footer');

        $this->template->load('main_home', $partials, $data);
    }

    public function zwemmer($id)
    {
        $data['titel'] = 'Contacteer';
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        $this->load->model('persoon_model');

        $zwemmer = $this->persoon_model->get($id);

        $data['email'] = $zwemmer->mailadres;
        $data['id'] = $zwemmer->id;

        $partials = array(
            'inhoud' => 'bezoeker/contact',
            'footer' => 'main_home');

        $this->template->load('main_master', $partials, $data);

    }

    public function trainers()
    {
        $data['titel'] = 'Contacteer trainers';
        $data['eindverantwoordelijke'] = "Neil Van den Broeck";

        $this->load->model('persoon_model');

        $trainers = $this->persoon_model->getTrainers();

        $emails = "";

        for ($i = 0; $i < count($trainers); $i++) {
            $emails .= $trainers[$i]->mailadres;
            if ($i < (count($trainers) - 1)) {
                $emails .= ",";
            }
        }

        $data['email'] = $emails;
        $data['id'] = "";

        $partials = array(
            'inhoud' => 'bezoeker/contact',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function verwerk()
    {
        $email = $this->input->post('email');
        $emailzwemmer = $this->input->post('emailzwemmer');
        $bericht = $this->input->post('bericht');

        $headers = 'From: ' . $email;

        $onderwerp = "Informatie Wezenberg";

        var_dump($emailzwemmer, $onderwerp, $bericht, $headers);

        $id = $this->input->post('id');
        if ($id == "") {
            redirect('bezoeker/Home');
        } else {
            redirect('bezoeker/Home/zwemmer/' . $id);
        }

    }
}
