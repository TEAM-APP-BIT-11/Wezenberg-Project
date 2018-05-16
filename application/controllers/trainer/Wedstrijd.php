<?php
 /**
  * @class Wedstrijd
  * @brief Controller-klasse voor Wedstrijden beheren van de trainer
  * @author Stef Schoeters
  *
  * Controller-klasse met alle methoden die gebruikt worden in de Wedstrijden beheren pagina van de trainer
  */

class Wedstrijd extends CI_Controller
{
  /**
  * Contructor
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
     * Haalt al de bestaande wedstrijden (en aangevuld met locatie) op via Wedstrijd_model en toont het resulterende object in de view trainer/wedstrijden_beheren.php
     *
     * @author Stef Schoeters
     * @see Wedstrijd_model::getAllWithLocatie()
     * @see trainer/wedstrijden_beheren.php
     */

    public function beheren()
    {
        $data['titel'] = 'Wedstrijden beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $data['error'] = "";

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAllWithLocatie();

        $partials = array('inhoud' => 'trainer/wedstrijden_beheren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }

     /**
      * Haalt de wedstrijd met id=$id (en locaties, slag, afstand) op via Wedstrijd_model, Locatie_model, Wedstrijdreeks_model en toont het resulterende object in de view trainer/wedstrijd_aanpassen.php
      *
      * @param $id De id van de wedstrijd dat getoond wordt
      * @see Wedstrijd_model::get()
      * @see Locatie_model::getAll()
      * @see Wedstrijdreeks_model::getAllWithWedstrijdSlagAfstandById()
      * @see trainer/wedstrijd_aanpassen.php
      */

    public function aanpassen($id)
    {
        $data['titel'] = 'Wedstrijd aanpassen';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $this->load->model('wedstrijdreeks_model');
        $data['wedstrijdreeksen'] = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandById($id);

        $partials = array('inhoud' => 'trainer/wedstrijd_aanpassen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Toont een formulier voor het toevoegen van een nieuwe wedstrijd
     * en haalt de locaties, afstanden en slagen op op via Locatie_model, Slag_model en toont de resulterende objecten
     * met al dan niet een error in de view trainer/wedstrijd_toevoegen.php
     *
     * @author Stef Schoeters
     * @param $error De error die al dan niet getoond wordt
     * @see Locatie_model::getAll()
     * @see Afstand_model::getAll()
     * @see Slag_model::getAll()
     * @see trainer/wedstrijd_toevoegen.php
     */

    public function toevoegen($error)
    {
        $data['titel'] = 'Wedstrijd toevoegen';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        if($error == "nieuw"){
          $data['error'] = "";
        }else{
        $data['error'] = $error;
        }

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();

        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();

        $partials = array('inhoud' => 'trainer/wedstrijd_toevoegen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Maakt een nieuwe wedstrijd (en een melding voor de zwemmers dat er een nieuwe wedstrijd is) aan met de ingevulde gegevens uit het formulier
     * via Wedstrijd_model ook wordt er gecontroleerd of de einddatum niet voor de begindatum valt
     *
     * @author Stef Schoeters
     * @see Wedstrijd_model::insert()
     * @see Persoon_model::genereerMeldingen()
     * @see trainer/wedstrijd_toevoegen.php
     */

    public function aanmaken()
    {
        $wedstrijd = new stdClass();

        $wedstrijd->naam = $this->input->post('naam');
        $wedstrijd->locatieId = $this->input->post('locatie');

        $beginDatum = $this->input->post('begindatum');
        $wedstrijd->begindatum = $beginDatum;

        $eindDatum = $this->input->post('einddatum');
        $wedstrijd->einddatum = $eindDatum;

        $wedstrijd->extraInfo = $this->input->post('extraInfo');

        if($beginDatum != ""){
          $NieuweBeginDatum = new DateTime($beginDatum);
          $NieuweBeginDatumTime = $NieuweBeginDatum->getTimestamp();
        }else{
          $NieuweBeginDatumTime = 0;
        }

        if($eindDatum != ""){
          $NieuweEindDatum = new DateTime($eindDatum);
          $NieuweEindDatumTime = $NieuweEindDatum->getTimestamp();
        }else{
          $NieuweEindDatumTime = 0;
        }

        if($NieuweBeginDatumTime != 0 & $NieuweEindDatumTime != 0){
          if($NieuweBeginDatumTime <= $NieuweEindDatumTime){
            $this->load->model('wedstrijd_model');
            $wedstrijdId = $this->wedstrijd_model->insert($wedstrijd);
            $data['id'] = $wedstrijdId;

            $this->load->model('persoon_model');
            $this->melding->genereerMeldingen($this->persoon_model->getZwemmers(), 'Er is een nieuwe wedstrijd ' . $wedstrijd->naam . ' toegevoegd', 'Nieuwe Wedstrijd');
            return $this->beheren();
          }else{
            $error = "Toevoegen mislukt! De einddatum valt voor de begindatum";
            return $this->toevoegen($error);
          }
        }else{
          $this->load->model('wedstrijd_model');
          $wedstrijdId = $this->wedstrijd_model->insert($wedstrijd);
          $data['id'] = $wedstrijdId;

          $this->load->model('persoon_model');
          $this->melding->genereerMeldingen($this->persoon_model->getZwemmers(), 'Er is een nieuwe wedstrijd ' . $wedstrijd->naam . ' toegevoegd', 'Nieuwe Wedstrijd');
          return $this->beheren();
        }

    }

    /**
     * Past een bestaande wedstrijd aan met de aangepaste gegevens uit het formulier via Wedstrijd_model
     *
     * @author Stef Schoeters
     * @see Wedstrijd_model::update()
     * @see trainer/wedstrijd_aanpassen.php
     */

    public function pasAan()
    {
        $wedstrijd = new stdClass();

        $wedstrijd->naam = $this->input->post('naam');
        $wedstrijd->locatieId = $this->input->post('locatie');
        $wedstrijd->begindatum = $this->input->post('begindatum');
        $wedstrijd->einddatum = $this->input->post('einddatum');
        $wedstrijd->extraInfo = $this->input->post('extraInfo');
        $wedstrijd->id = $this->input->post('id');

        $this->load->model('wedstrijd_model');
        $this->wedstrijd_model->update($wedstrijd);

        return $this->beheren();
    }

    /**
     * Verwijderd de wedstrijd met id=$id via Wedstrijd_model
     * met al dan niet een error in de view trainer/wedstrijd_beheren.php
     *
     * @author Stef Schoeters
     * @param $id De id van de wedstrijd dat verwijderd wordt
     * @see Wedstrijd_model::delete()
     * @see Wedstrijd_model::getAllWithLocatie()
     * @see trainer/wedstrijd_beheren.php
     */

    public function verwijder($id)
    {
        $data['titel'] = 'Wedstrijden beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijd_model');
        $data['error'] = $this->wedstrijd_model->delete($id);

        $this->load->model('wedstrijd_model');
        $data['wedstrijden'] = $this->wedstrijd_model->getAllWithLocatie();

        $partials = array('inhoud' => 'trainer/wedstrijden_beheren',
            'footer' => 'main_footer');
        $this->template->load('main_master', $partials, $data);
    }
}
