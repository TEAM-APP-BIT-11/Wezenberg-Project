<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @class Contact
 * @brief Controller-klasse
 * Controller-klasse voor de contacteermethoden die gebruikt worden in de webapplicatie
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
        $this->load->library('email');
    }

    /**
     * Geeft contactpagina voor de trainers weer
     * (Index wordt normaal gezien niet opgeroepen)
     * @author Neil Van den Broeck
     * @see <trainers>
     */

    public function index()
    {
        redirect('bezoeker/Contact/trainers');
    }

    /**
     * Contacteerfunctie voor een zwemmer
     * de persoon word opgehaald uit Persoon_model en het mailadres ($email) en ($id) ervan worden doorgestuurd naar de view bezoeker/contact.php
     * @param $id is de id van de zwemmer die de persoon wilt contacteren
     * @author Neil Van den Broeck
     */

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

    /**
     * Contacteer voor de trainers van Wezenberg.
     * De trainers worden opgehaald uit Persoon_model.
     * De de emailadressen van de trainers worden gescheiden door een komma door in de variabele $email aan bezoeker/contact.php
     * $id = "" omdat er na het verzenden van het formulier moet teruggekeerd worden naar de homepagina (@see <verwerk>)
     * @author Neil Van den Broeck
     */

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
                $emails .= ", ";
            }
        }

        $data['email'] = $emails;
        $data['id'] = "";

        $partials = array(
            'inhoud' => 'bezoeker/contact',
            'footer' => 'main_footer');

        $this->template->load('main_home', $partials, $data);
    }

    /**
     * Stuurt een mail naar de geselecteerde e-mailadressen via de g-mailserver en mailfunctie van CodeIgniter.
     * voor een mail naar een zwemmer bevat $id de id van de zwemmer waarnaar de functie terugkeert.
     * Indien de mail naar wezenberg gestuurd werd (trainers) dan is $id = "" en word er naar de homepagina voor de bezoeker teruggekeerd.
     * @author Neil Van den Broeck
     * @return Stuurt de pagina terug naar de pagina waar ze waren voordat ze het formulier om te contacteren invulden.
     */
    public function verwerk()
    {
        $email = $this->input->post('email');
        $emailzwemmer = $this->input->post('emailzwemmer');
        $bericht = $this->input->post('bericht');

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'newline' => "\r\n",
            'smtp_port' => 465,
            'smtp_user' => 'projectwezenberg@gmail.com',
            'smtp_pass' => 'wezenberg',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->email->initialize($config);

        $this->email->to($emailzwemmer);
        $this->email->from('projectwezenberg@gmail.com');

        $this->email->subject('Informatie van wezenberg');
        $this->email->message('bericht van ' . $email . "\n" . $bericht);

        if (!$this->email->send()) {
            echo "FOUT";
        } else {


            $id = $this->input->post('id');
            if ($id == "") {
                redirect('bezoeker/Home');
            } else {
                redirect('bezoeker/Home/zwemmer/' . $id);
            }
        }
    }
}
