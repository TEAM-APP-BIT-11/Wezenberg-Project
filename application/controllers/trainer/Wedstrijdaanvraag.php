<?php
/**
  * @class Wedstrijdaanvraag
  * @brief Controller-klasse voor de wedstrijdaanvragen beheren voor de trainer
  * @author Ruben Tuytens
  *
  * Controller-klasse met alle methoden die gebruikt worden in de wedstrijdaanvragen beheren pagina van de trainer
  */
class Wedstrijdaanvraag extends CI_Controller
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
/**
     * Haalt al de wedstrijdreeks records (met overeenkomstige wedstrijddeelnamens slag afstand en wedstrijd) op uit Wedstrijdreeks_model en geeft de view trainer/wedstrijdaanvraag_goedkeuren.php waarme verder actie kan ondernomen worden
     * Haalt alle persoon records (met overeenkomstige wedstrijddeelnamens op uit Persoon_model op en geeft deze ook door naar de view trainer/wedstrijdaanvraag_goedkeuren.php
     * @author Ruben Tuytens
     
     * @see Wedstrijdreeks_model::getAlles()
     
     * @see trainer/Wedstrijdaanvraag_goedkeuren.php
     */
    public function beheren()
    {
        $data['titel'] = 'Wedstrijdaanvragen beheren';
        $data['persoon'] = $this->authex->getPersoonInfo();
        $data['eindverantwoordelijke'] = "Ruben Tuytens";

        $this->load->model('persoon_model');

        $this->load->model('wedstrijdreeks_model');

        $data['personen'] = $this->persoon_model->getAll();
        $data['alles'] = $this->wedstrijdreeks_model->getAlles();
        $partials = array(
            'inhoud' => 'trainer/Wedstrijdaanvraag_goedkeuren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
/** 
     * Past de geselecteerde wedstrijddeelname record aan met overeenkomstige id = $deelnameId waar de statusId dan naar 2 wordt gezet
     * @param $deelnameId De id van de wedstrijddeelname record waarvan de statusId moet worden aangepast
     * @author Ruben Tuytens
     * @see Wedstrijddeelname_model::get()
     * @see Wedstrijddeelname_model::update()
     * @see trainer/Wedstrijdaanvraag_goedkeuren.php
     */

    public function goedkeuren($deelnameId)
    {

        $this->load->model('wedstrijddeelname_model');

        $aangepaste = $this->wedstrijddeelname_model->get($deelnameId);
        $aangepaste->statusId = 2;

        $this->wedstrijddeelname_model->update($aangepaste);

        redirect('trainer/wedstrijdaanvraag/beheren');
    }
/** 
     * Past de geselecteerde wedstrijddeelname record aan met overeenkomstige id = $deelnameId waar de statusId dan naar 3 wordt gezet
     * @param $deelnameId De id van de wedstrijddeelname record waarvan de statusId moet worden aangepast
     * @author Ruben Tuytens
     * @see Wedstrijddeelname_model::get()
     * @see Wedstrijddeelname_model::update()
     * @see trainer/Wedstrijdaanvraag_goedkeuren.php
     */
    public function afwijzen($deelnameId)
    {
        $this->load->model('wedstrijddeelname_model');

        $aangepaste = $this->wedstrijddeelname_model->get($deelnameId);
        $aangepaste->statusId = 3;

        $this->wedstrijddeelname_model->update($aangepaste);

        redirect('trainer/wedstrijdaanvraag/beheren');
    }
    
/** 
     * Haalt de geselecteerde wedstrijddeelname record (met de persoon, wedstrijdreeks, wedstrijd en welke verschillende slagen en afstanden er zijn voor deze deelname) met overeenkomstige id = $id  uit Wedstrijddeelname_model
     * Haalt de huidige waarde voor de slag en afstand op van het huidige wedstrijdreeks record waar de wedstrijddeelname tot hoort uit Wedstrijdreeks_model
     * @param $id De id van de wedstrijddeelname record waarvan de gegevens moeten gehaald worden
     * @author Ruben Tuytens
     * @see Wedstrijddeelname_model::getEnkelPersoonWithDeelnamens()
     * @see Wedstrijdreeks_model::getWithWedstrijdSlagAfstand()
     * @see trainer/Wedstrijdaanvraag_aanpassen.php
     */    
	public function wijzigen($id){
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['titel'] = 'Wedstrijdaanvraag wijzigen';
        
        $data['persoon'] = $this->authex->getPersoonInfo();
        $this->load->model('wedstrijdreeks_model');
        
        $this->load->model('wedstrijddeelname_model');

        $this->load->model('wedstrijdreeks_model');

        $data['deelname'] = $this->wedstrijddeelname_model->getEnkelPersoonWithDeelnamens($id);
        $data['huidigeSlagAfstand'] = $this->wedstrijdreeks_model->getWithWedstrijdSlagAfstand($data['deelname']->wedstrijdReeksId);
        
        $partials = array(
            'inhoud' => 'trainer/Wedstrijdaanvraag_aanpassen',
            'footer' => 'main_footer');
         
        $this->template->load('main_master', $partials, $data);
    }
/** 
     * Past de Wedstrijddeelname record aan met de ingegeven gegevens uit het formulier via Wedstrijddeelname_model
     * Nadat het juiste wedstrijdreeks record is gevonden dat nodig is voor de Wedstrijddeelname aan te passen via Wedstrijdreeks_model
     * @author Ruben Tuytens
     * @see Wedstrijdreeks_model::getWedstrijdreeks()
     * @see Wedstrijddeelname_model::update()
     * @see trainer/Wedstrijdaanvraag_aanpassen.php
     */     
    public function aanpassen(){
       
   
       
        $wedstrijdId= $this->input->post('wedstrijdId');
        $afstandId = $this->input->post('afstand');
        $slagId = $this->input->post('slag');
        $statusId = $this->input->post('statusId');
        $this->load->model('wedstrijdreeks_model');
        
        $wedstrijdreeks = $this->wedstrijdreeks_model->getWedstrijdreeks($wedstrijdId, $afstandId, $slagId);
        
        $wedstrijdDeelname = new stdClass();
        $wedstrijdDeelname->id = $this->input->post('deelnameId');
        $wedstrijdDeelname->persoonId = $this->input->post('persoonId');
        $wedstrijdDeelname->wedstrijdReeksId = $wedstrijdreeks->id;
        if($statusId == 2)
        {
            $wedstrijdDeelname->statusId = 1;
        }
        $this->load->model('wedstrijddeelname_model');
        $this->wedstrijddeelname_model->update($wedstrijdDeelname);
        redirect('trainer/wedstrijdaanvraag/beheren');
    }
    /** 
     *  Geeft alle afstanden terug voor een slagId via Wedstrijdreeks_model
     *  Geeft de overeenkomstige afstanden via JSON terug.
     * @author Ruben Tuytens
     * @see Wedstrijdreeks_model::getAllAfstandenForSlag()
     */
    public function haalSlagenAfstand()
    {
        $slagId = $this->input->get('slagId');
        $wedstrijdId = $this->input->get('wedstrijdId');
        $this->load->model('wedstrijdreeks_model');
        $afstanden = $this->wedstrijdreeks_model->getAllAfstandenForSlag($slagId, $wedstrijdId);

        echo json_encode($afstanden);
    }

}
