<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of startpagina
 *
 * @author Ruben
 */
class startpagina extends CI_Controller {
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
        
        $this->load->helper('html');
      
        $this->load->helper('form');
        $this->load->helper('notation');
    }
    
    public function beheren(){
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['title'] = 'Startpagina beheren';
        
        $this->load->model('nieuwsitem_model');
       $this->load->model('homepagina_model');
        
        $data['nieuwsitems']= $this->nieuwsitem_model->getAll();
        $data['homepaginaitem']= $this->homepagina_model->get(1);
      
        
        $partials = array(
            'inhoud' => 'trainer/homepagina_beheren', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    public function verwijderen($id){
        $this->load->model('nieuwsitem_model');
        
        $data['item'] = $this->nieuwsitem_model->get($id);
        $test = new stdClass();
        $test->id= $id;
        $test->tekst = $data['item']->tekst;
        $test->foto = $data['item']->foto;
        $test->titel = $data['item']->titel;
        $test->actief = 0;
        $test->datum = $data['item']->datum;
        $test->homepaginaId = $data['item']->homepaginaId;
        $this->nieuwsitem_model->update($test);
          redirect('/trainer/startpagina/beheren');
    }
    public function activeren($id)
    {
        $this->load->model('nieuwsitem_model');
        
        $data['item'] = $this->nieuwsitem_model->get($id);
        $test = new stdClass();
        $test->id= $id;
        $test->tekst = $data['item']->tekst;
        $test->foto = $data['item']->foto;
        $test->titel = $data['item']->titel;
        $test->actief = 1;
        $test->datum = $data['item']->datum;
        $test->homepaginaId = $data['item']->homepaginaId;
        $this->nieuwsitem_model->update($test);
          redirect('/trainer/startpagina/beheren');
    }
    public function wijzigen($id)
    {
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['title'] = 'Nieuwsitem wijzigen';
        $this->load->model('nieuwsitem_model');
        
        $data['nieuwsitem'] = $this->nieuwsitem_model->get($id);
         $partials = array(
            'inhoud' => 'trainer/nieuwsitem_wijzigen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
        
    }
    public function toevoegen()
    {
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['title'] = 'Nieuwsitem toevoegen';
        
        
        
         $partials = array(
            'inhoud' => 'trainer/nieuwsitem_toevoegen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
        
    }
    public function toevoegenOpslaan(){
        
       
       
             $config['upload_path'] = './resources/img/nieuwsitems/';
        $config['allowed_types'] = 'gif|jpg|png';
       
        $config['file_name'] = $_FILES['userfile']['name'];
        $config['overwrite'] = TRUE;
        
         $this->load->library('upload', $config);
        $item = new stdClass();
       $item->id = $this->input->post('id');
        $item->tekst = $this->input->post('tekst');
          $item->titel = $this->input->post('titel');
        $item->actief = 1;
        $item->datum = date('Y-m-d');
        $item->homepaginaId = 1;
        
        $this->load->model('nieuwsitem_model');
      
        if( $this->upload->do_upload('userfile')){
        
          
        
        $item->foto = $_FILES['userfile']['name'];
      
        
        } else{
       
        $item->foto = '';
        
        }
        $this->nieuwsitem_model->insert($item);
        redirect('/trainer/startpagina/beheren');
  
    }
    
    public function wijzigingOpslaan(){
       
         $config['upload_path'] = './resources/img/nieuwsitems/';
        $config['allowed_types'] = 'gif|jpg|png';
       $config['overwrite'] = TRUE;
        $config['file_name'] = $_FILES['userfile']['name'];
       
        
         $this->load->library('upload', $config);
         
         $item = new stdClass();
       $item->id = $this->input->post('id');
        $item->tekst = $this->input->post('tekst');
         $item->titel = $this->input->post('titel');
        $item->actief = 1;
        $item->datum = date('Y-m-d');
        $item->homepaginaId = 1;
        
        $this->load->model('nieuwsitem_model');
        
        if( $this->upload->do_upload('userfile')){
      $item->foto = $_FILES['userfile']['name'];
       

        }else{
       
        $item->foto =  $this->input->post('foto');
        
        
        
       
        
        }
         $this->nieuwsitem_model->update($item);
         redirect('/trainer/startpagina/beheren');
        
        
        
    }
	 public function homepaginaOpslaan(){
            $config['upload_path'] = './resources/img/nieuwsitems/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = TRUE;
            $config['file_name'] = $_FILES['userfile']['name'];
            $this->load->library('upload', $config);
            
        $item = new stdClass();
        
        $item->id = 1;
      
        $item->informatie = $this->input->post('infoblok');
        $this->load->model('homepagina_model');
      
        
        if( $this->upload->do_upload('userfile')){
         $item->groepsfoto = $_FILES['userfile']['name'];
        }else{
       
        $item->groepsfoto =  $this->input->post('groepsfoto');
        }
        $this->homepagina_model->update($item);
        redirect('/trainer/startpagina/beheren');
    }
}
