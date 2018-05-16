<?php
/**
  * @class Supplement
  * @brief Controller-klasse voor de Supplementen beheren voor de trainer
  * @author Ruben Tuytens
  *
  * Controller-klasse met alle methoden die gebruikt worden in de supplementen beheren pagina van de trainer
  */
class Supplement extends CI_Controller
{
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

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    public function beheren()
    {
        /**
     * Haalt al de supplementdoelstellingen records op uit Supplementdoelstelling_model en geeft de view trainer/supplementen_beheren.php waarme verder actie kan ondernomen worden
     * @author Ruben Tuytens
     
     * @see Supplementdoelstelling_model::getAll()
     * @see trainer/supplementen_beheren.php
     */
        $data['titel'] = 'supplementen beheren';
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $this->load->model('supplementdoelstelling_model');
        $data['error'] = '';
        $data['doelstellingen'] = $this->supplementdoelstelling_model->getAll();
      
        $partials = array(
            'inhoud' => 'trainer/supplementen_beheren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
  /**
     * Kijkt na welke functie er moet uitgevoerd worden. 
     * Of er wordt doorgegaan naar de view /trainer/doelstelling_aanpassen.php waar dan de huidige geselecteerde doelstelling kan aangepast worden. Deze wordt doorgestuurd via de Supplementdoelstelling_model
     * Of de view /trainer/doelstelling_toevoegen.php wordt opgeroepen. Waar er een nieuwe doelstelling kan toegevoegd worden.
     * Of de huidige geselecteerde doelstelling wordt verwijderd met behulp van de geselecteerde supplementdoelstelling Id via Supplementdoelstelling_model
     * @author Ruben Tuytens
     * @see Supplementdoelstelling_model::get()
     * @see Supplementdoelstelling_model::delete()
     * @see trainer/doelstelling_aanpassen.php
     * @see trainer/doelstelling_toevoegen.php
     * @see trainer/supplementen_beheren.php
     */  
    
    
    public function wijzigen()
    {
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $supplement = $this->input->post('doelstelling');
        $this->load->model('supplementdoelstelling_model');
        $uitvoeren = $this->input->post('doelstellingen');
        if ($uitvoeren == 'aanpassen') {
            if ($supplement == 0) {
                redirect('/trainer/supplement/beheren');
            } else {
                $data['titel'] = 'Doelstelling wijzigen';
                $data['supplement'] = $this->supplementdoelstelling_model->get($supplement);
            }
            $partials = array(
                'inhoud' => 'trainer/doelstelling_aanpassen',
                'footer' => 'main_footer');
        } elseif ($uitvoeren == 'toevoegen') {
            $data['titel'] = 'Doelstelling toevoegen';
            
            $partials = array(
                'inhoud' => 'trainer/doelstelling_toevoegen',
                'footer' => 'main_footer');
        } elseif ($uitvoeren == 'verwijderen') {
            $this->load->model('voedingssupplement_model');
           // $this->voedingssupplement_model->verwijderAlleSupplementen($supplement);
            $this->supplementdoelstelling_model->delete($supplement);
           return $this->beheren();
        }

        $this->template->load('main_master', $partials, $data);
    }

    /** 
     *  Geeft alle voedingssupplementen terug voor een doelstellingId via Voedingssupplement_model
     *  Geeft de overeenkomstige voedingssupplementen via JSON terug.
     * @author Ruben Tuytens
     * @see Voedingssupplement_model::getAllByDoelstelling()
     */
    public function haalVoedingProducten()
    {
        $doelstellingId = $this->input->get('doelstellingId');

        $this->load->model('voedingssupplement_model');
        $voedingen = $this->voedingssupplement_model->getAllByDoelstelling($doelstellingId);

        echo json_encode($voedingen);
    }
    /** 
     *  Past een supplementdoelstelling aan met gegevens van het formulier via Supplementdoelstelling_model
     * @author Ruben Tuytens
     * @see Supplementdoelstelling_model::update()
     */
    public function opslaan()
    {
        $doelstelling = new stdClass();
        $doelstelling->id = $this->input->post('doelstellingId');
        $doelstelling->doelstelling = $this->input->post('doelstelling');


        $this->load->model('supplementdoelstelling_model');

        $this->supplementdoelstelling_model->update($doelstelling);


       return $this->beheren();
    }
/** 
     *  Maakt een nieuw supplementdoelstelling aan met gegevens van het formulier via Supplementdoelstelling_model
     *  Controleert of alle gegevens die nodig zijn zijn ingevuld.
     * @author Ruben Tuytens
     * @see Supplementdoelstelling_model::insert()
     */
    public function toevoegen()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('doelstelling', 'doelstelling', 'required', array('required' => 'Je moet een %s ingeven.'));
        
         $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
         
         if($this->form_validation->run() == FALSE)
         {
             $data['titel'] = 'Doelstelling toevoegen';
            
            $partials = array(
                'inhoud' => 'trainer/doelstelling_toevoegen',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
         }
         else
         {
              $doelstelling = new stdClass();
        $doelstelling->id = $this->input->post('doelstellingId');
        $doelstelling->doelstelling = $this->input->post('doelstelling');

        $this->load->model('supplementdoelstelling_model');

        $this->supplementdoelstelling_model->insert($doelstelling);

       return $this->beheren();
         }
         
        
        
    }
 /**
     * Kijkt na welke functie er moet uitgevoerd worden. 
     * Of er wordt doorgegaan naar de view /trainer/supplement_aanpassen.php waar dan het huidig geselecteerde voedingssupplement kan aangepast worden. Deze wordt doorgestuurd via de Voedingssupplement_model
     * Of de view /trainer/Supplement_toevoegen.php wordt opgeroepen. Waar er een nieuw supplement kan toegevoegd worden waar ook al de huidige doelstellingen worden mee ingeladen via Supplementdoelstelling_model.
     * Of het huidige geselecteerde voedingssupplement wordt verwijderd met behulp van de geselecteerde voedingssupplementId via Voedingssupplement_model
     * @author Ruben Tuytens
     * @see Voedingssupplement_model::getWithDoelstelling()
     * @see Voedingssupplement_model::delete() 
     * @see Supplementdoelstelling_model::getAll()
     * @see trainer/supplement_aanpassen.php
     * @see trainer/supplement_toevoegen.php
     * @see trainer/supplementen_beheren.php
     */  
    public function supplementVerandering()
    {
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $supplement = $this->input->post('supplementen');
        $doelstelling = $this->input->post('doelstelling');
        $this->load->model('supplementdoelstelling_model');
        $this->load->model('voedingssupplement_model');
        $uitvoeren = $this->input->post('supplement');
        if ($uitvoeren == 'aanpassen') {
            if ($supplement == 0) {
                return $this->beheren();
            } else {
                $data['titel'] = 'Supplement wijzigen';
                $data['supplement'] = $this->voedingssupplement_model->getWithDoelstelling($supplement);
                
            }


            $partials = array(
                'inhoud' => 'trainer/supplement_aanpassen',
                'footer' => 'main_footer');
        } elseif ($uitvoeren == 'toevoegen') {
            $data['titel'] = 'Supplement toevoegen';
    
             $data['doelstellinghuidig'] = $this->input->post('doelstellingwaarde');
            $data['doelstellingen'] = $this->supplementdoelstelling_model->getAll();
          
            $partials = array(
                'inhoud' => 'trainer/supplement_toevoegen',
                'footer' => 'main_footer');
        } elseif ($uitvoeren == 'verwijderen') {
            
            $this->voedingssupplement_model->delete($supplement);
            if($this->voedingssupplement_model->get($supplement) == NULL)
            {
               return $this->beheren();
            }
            else
            {
               $data['error'] = 'Er zijn nog innnames van zwemmers die dit supplement gebruiken';
               $data['titel'] = 'supplementen beheren';
         
         $this->load->model('supplementdoelstelling_model');
        
        $data['doelstellingen'] = $this->supplementdoelstelling_model->getAll();
      
        $partials = array(
            'inhoud' => 'trainer/supplementen_beheren',
            'footer' => 'main_footer');
       
            }
          
        }

      $this->template->load('main_master', $partials, $data);
    }
/** 
     *  Past een voedingssupplement aan met gegevens van het formulier via Voedingssupplement_model
     * @author Ruben Tuytens
     * @see Voedingssupplement_model::update()
     */
    public function voedingOpslaan()
    {
        $supplement = new stdClass();
        $supplement->id = $this->input->post('supplementId');
        $supplement->doelstellingId = $this->input->post('doelstellingId');
        $supplement->naam = $this->input->post('voedingssupplement');


        $this->load->model('voedingssupplement_model');

        $this->voedingssupplement_model->update($supplement);


        return $this->beheren();
    }
/** 
     *  Maakt een nieuw voedingssupplement aan met gegevens van het formulier via Voedingssupplement_model
     *  Controleert of alle gegevens die nodig zijn zijn ingevuld.
     * @author Ruben Tuytens
     * @see Voedingssupplement_model::insert()
     */
    public function supplementToevoegen()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('suppla', 'supplement', 'required', array('required' => 'Je moet een %s ingeven.'));
        
             $this->form_validation->set_rules('doelstelling', 'doelstelling', 'required|callback_select_validate');
        $abcd = $this->input->post('doelstelling');
        
         $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
         
         if($this->form_validation->run() == FALSE)
         {
             $this->load->model('supplementdoelstelling_model');
    
             $data['titel'] = 'Supplement toevoegen';
            $data['doelstellinghuidig']= $this->input->post('doelstelling');
     
            $data['doelstellingen'] = $this->supplementdoelstelling_model->getAll();
            
            $partials = array(
                'inhoud' => 'trainer/supplement_toevoegen',
                'footer' => 'main_footer');
            $this->template->load('main_master', $partials, $data);
         }else
         {
            $supplement = new stdClass();
        $supplement->id = $this->input->post('supplementId');
        $supplement->naam = $this->input->post('suppla');
        $supplement->doelstellingId = $this->input->post('doelstelling');

        $this->load->model('voedingssupplement_model');

        $this->voedingssupplement_model->insert($supplement);

       return $this->beheren();
         }
        
        
    }
    function select_validate($abcd){
        if($abcd==0){
            $this->form_validation->set_message('select_validate', 'Kies een doelstelling.');
return false;
} else{
// User picked something.
return true;
}
        }
    
}
