<?php
/**
  * @class startpagina
  * @brief Controller-klasse voor de startpagina te beheren voor de trainer
  * @author Ruben Tuytens
  *
  * Controller-klasse met alle methoden die gebruikt worden om de startpagina te beheren pagina van de trainer
  */
class startpagina extends CI_Controller {
   /**
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
        
        $this->load->helper('html');
      
        $this->load->helper('form');
        $this->load->helper('notation');
    }
/**
     * Haalt al de nieuwsitem records op met Nieuwsitem_model
     * Haalt de homepagina record op met Homepagina_model
     * Stuurt deze allemaal door naar de view trainer/homepagina_beheren.php
     * @author Ruben Tuytens
     
     * @see Nieuwsitem_model::getAll()
     * @see Homepagina_model::get()
     * @see trainer/homepagina_beheren.php
     */    
    public function beheren(){
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['titel'] = 'Startpagina beheren';
        
        $this->load->model('nieuwsitem_model');
       $this->load->model('homepagina_model');
        
        $data['nieuwsitems']= $this->nieuwsitem_model->getAll();
        $data['homepaginaitem']= $this->homepagina_model->get(1);
      
        
        $partials = array(
            'inhoud' => 'trainer/homepagina_beheren', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
/**
 * Verandert het nieuwsitem met id = $id van het geselecteerde nieuwsitem en zorgt dat deze niet meer actief is.
 * @param $id van het nieuwsitem dat op niet actief moet gezet worden
 * @author Ruben Tuytens 
 * @see Nieuwsitem_model::get()
 * @see Nieuwsitem_model::update()
 * @see trainer/homepagina_beheren.php
 */
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
    /**
 * Verandert het nieuwsitem met id = $id van het geselecteerde nieuwsitem en zorgt dat deze actief is.
 * @param $id van het nieuwsitem dat op actief moet gezet worden
 * @author Ruben Tuytens 
 * @see Nieuwsitem_model::get()
 * @see Nieuwsitem_model::update()
 * @see trainer/homepagina_beheren.php
 */
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
    /**
 * Haalt het nieuwsitem met id = $id van het geselecteerde nieuwsitem op uit Nieuwsitem_model en toont het object op de view trainer/nieuwsitem_wijzigen.php 
 * Haalt alle nieuwsitems op uit Nieuwsitem_model en stuurt deze door naar de view trainer/nieuwsitem_wijzigen.php 
 * @param $id van het nieuwsitem waarvan de gegevens moeten worden opgehaald
 * @author Ruben Tuytens 
 * @see Nieuwsitem_model::get()
 * @see Nieuwsitem_model::getAll()
 * @see trainer/nieuwsitem_wijzigen.php
 */
    public function wijzigen($id)
    {
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['titel'] = 'Nieuwsitem wijzigen';
        $this->load->model('nieuwsitem_model');
        
        $data['nieuwsitem'] = $this->nieuwsitem_model->get($id);
        $data['fotos'] = $this->nieuwsitem_model->getAll();
         $partials = array(
            'inhoud' => 'trainer/nieuwsitem_wijzigen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
        
    }
    /**
 * Haalt alle nieuwsitems op uit Nieuwsitem_model en stuurt deze door naar de view trainer/nieuwsitem_wijzigen.php 
 
 * @author Ruben Tuytens 
 
 * @see Nieuwsitem_model::getAll()
 * @see trainer/nieuwsitem_toevoegen.php
 */
    public function toevoegen()
    {
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['titel'] = 'Nieuwsitem toevoegen';
        
        
         $this->load->model('nieuwsitem_model');
        $data['fotos'] = $this->nieuwsitem_model->getAll();
         $partials = array(
            'inhoud' => 'trainer/nieuwsitem_toevoegen', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
        
    }
    /** 
     *  Maakt een nieuw nieuwsitem record aan met gegevens van het formulier via Nieuwsitem_model
     *  Controleert of alle gegevens die nodig zijn zijn ingevuld via form_validation.
     *  Upload de geselecteerde foto in het juiste pad of neemt de huidige foto die geselecteerd is in het formulier
     * @author Ruben Tuytens
     * @see Nieuwsitem_model::insert()
     * @see trainer/nieuwsitem_toevoegen.php
     */
    public function toevoegenOpslaan(){
        
       $this->load->library('form_validation');
        $this->form_validation->set_rules('titel', 'titel', 'required', array('required' => 'Je moet een %s ingeven.'));
        $this->form_validation->set_rules('tekst', 'tekst', 'required', array('required' => 'Je moet een %s ingeven.'));
         $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       if($this->form_validation->run() == FALSE)
         {
             $data['titel'] = 'Nieuwsitem toevoegen';
             $data['eindverantwoordelijke'] = "Ruben Tuytens";
             $this->load->model('nieuwsitem_model');
        $data['fotos'] = $this->nieuwsitem_model->getAll();
            $partials = array(
                'inhoud' => 'trainer/nieuwsitem_toevoegen',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
         }
         else
         {
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
       
        $item->foto = $this->input->post('foto');
        
        }
        $this->nieuwsitem_model->insert($item);
        redirect('/trainer/startpagina/beheren');
         }
    }
    /** 
     *  Past het huidige nieuwsitem record aan met de aangepaste gegevens van het formulier via Nieuwsitem_model
   
     *  Upload de geselecteerde foto in het juiste pad of neemt de aangepaste/huidige foto die geselecteerd is in het formulier
     * @author Ruben Tuytens
     * @see Nieuwsitem_model::update()
     * @see trainer/nieuwsitem_toevoegen.php
     */
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
    /** 
     *  Past het huidige homepagina record aan met de aangepaste gegevens van het formulier via Homepagina_model
   
     *  Upload de geselecteerde foto in het juiste pad of neemt de aangepaste/huidige foto die geselecteerd is in het formulier
     * @author Ruben Tuytens
     * @see Homepagina_model::update()
     * @see trainer/homepagina_beheren.php
     */
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
