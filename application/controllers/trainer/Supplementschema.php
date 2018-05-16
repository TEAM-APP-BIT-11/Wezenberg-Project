<?php
/**
  * @class Supplementschema
  * @brief Controller-klasse voor het supplementen schema te beheren van de trainer
  * @author Ruben Tuytens
  *
  * Controller-klasse met alle methoden die gebruikt worden in de supplementen schema beheren pagina van de trainer
  */
class Supplementschema extends CI_Controller {
   /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->authex->isAangemeld()) {
            redirect('Algemeen/logIn');
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
/**

     * Haalt al de inname records (overeenkomstig met de juiste persoon en voedingssupplement) op via Inname_model en Persoon_model en toont de resultaten in de view trainer/supplementen_schema_beheren.php
     * @author Ruben Tuytens
     * @see Persoon_model::getPersoonWithInnames()
     * @see Inname_model::getInnamesPersonen()
     * @see trainer/supplementen_schema_beheren.php
     */
    public function beheren(){
        $data['titel'] = 'Schema van de supplementen';
        $data['persoon'] = $this->authex->getPersoonInfo();
         $data['eindverantwoordelijke'] = "Ruben Tuytens";


          $this->load->model('persoon_model');

          $this->load->model('inname_model');
         $data['personen']=$this->persoon_model->getPersoonWithInnames();
          $data['innames']=$this->inname_model->getInnamesPersonen();


           $partials = array(
            'inhoud' => 'trainer/supplementen_schema_beheren', 'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
/**

     * Haalt al de persoon records via Persoon_model, al de voedingssupplement records via Voedingssupplement_model en toont de resultaten in de view trainer/supplement_trainer_toevoegen.php
     * @author Ruben Tuytens
     * @see Persoon_model::getAll()
     * @see Voedingssupplement_model::getAll()
     * @see trainer/supplement_trainer_toevoegen.php
     */
    public function toevoegen(){
        $data['titel'] = 'Supplement toevoegen aan een zwemmer';
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $this->load->model('persoon_model');

          $this->load->model('voedingssupplement_model');
         $data['personen']=$this->persoon_model->getAll();
          $data['innames']=$this->voedingssupplement_model->getAll();

           $partials = array(
            'inhoud' => 'trainer/supplement_trainer_toevoegen','footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
/**

     * Maakt één of meerdere nieuwe inname records aan met de gegevens van het formulier via Inname_model
     * @author Ruben Tuytens
     * @see Inname_model::insert()
     * @see trainer/supplement_trainer_toevoegen.php
     */
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
    /**
     * Haalt het inname record met de id = $id van de geselecteerde inname op uit Inname_model met de overeenkomstige persoon uit Persoon_model en alle voedingssupplement records uit Voedingssupplement_model.
     * Toont het resultaat in de view trainer/supplement_aanpassen_in_schema
     * @param $id van de inname waarvan de gegevens moeten worden opgehaald
     * @author Ruben Tuytens
     * @see Inname_model::get()
     * @see Persoon_model::get()
     * @see Voedingssupplement_model::getAll()
     * @see trainer/supplement_aanpassen_in_schema.php
     */
    public function aanpassen($id){

           $data['titel'] = 'Supplement aanpassen';
          $data['eindverantwoordelijke'] = "Ruben Tuytens";
          $this->load->model('inname_model');
          $this->load->model('persoon_model');
          $this->load->model('voedingssupplement_model');
          $data['inname']=$this->inname_model->get($id);
          $data['persoon'] = $this->persoon_model->get($data['inname']->persoonId);
          $data['innames'] = $this->voedingssupplement_model->getAll();


           $partials = array(
            'inhoud' => 'trainer/supplement_aanpassen_in_schema' ,'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
    /**
     * Past het innamme record aan met de aangepaste gegevens uit het formulier via Inname_model
     * @author Ruben Tuytens
     * @see Inname_model::update()
     * @see trainer/supplement_aanpassen_in_schema.php
     */
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
    /**
     * Verwijdert het inname record met id = $id via Inname_model
     * @param $id van de inname dat verwijdert moet worden
     * @author Ruben Tuytens
     * @see Inname_model::delete()
     * @see trainer/supplementen_schema_beheren.php
     */
    public function verwijderen($id){
        $this->load->model('inname_model');

        $this->inname_model->delete($id);
            redirect('/trainer/supplementschema/beheren');
    }
}
