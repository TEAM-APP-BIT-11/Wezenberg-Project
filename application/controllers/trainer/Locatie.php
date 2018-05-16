<?php
  /**
   * @class Locatie
   * @brief Controller-klasse voor Locaties beheren van de trainer
   * @author Stef Schoeters
   *
   * Controller-klasse met alle methoden die gebruikt worden in de Locaties beheren pagina van de trainer
   */

class Locatie extends CI_Controller
{
  /**
  * Contructor
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
    }

    /**
     * Haalt al de bestaande locaties op via Locatie_model en toont het resulterende object in de view trainer/locaties_beheren.php
     *
     * @author Stef Schoeters
     * @see Locatie_model::getAll()
     * @see trainer/locatie_beheren.php
     */

    public function beheren()
    {
        $data['titel'] = 'Locaties beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();
        $data['error'] = "";

        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $partials = array(
            'inhoud' => 'trainer/locatie_beheren',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt de locatie met id=$id op via Locatie_model en toont het resulterende object in de view trainer/locatie_aanpassen.php
     *
     * @param $id De id van de locatie dat getoond wordt
     * @see Locatie_model::get()
     * @see trainer/locatie_aanpassen.php
     */

    public function aanpassen($id)
    {
        $data['titel'] = 'Locatie beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('locatie_model');
        $data['locatie'] = $this->locatie_model->get($id);

        $partials = array(
            'inhoud' => 'trainer/locatie_aanpassen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }


    /**
     * Past een bestaande locatie aan met de aangepaste gegevens uit het formulier via Locatie_model
     *
     * @author Stef Schoeters
     * @see Locatie_model::update()
     */

    public function pasAan()
    {
        $locatie = new stdClass();

        $locatie->naam = html_escape($this->input->post('naam'));
        $locatie->straat = html_escape($this->input->post('straat'));
        $locatie->nr = html_escape($this->input->post('nr'));
        $locatie->postcode = html_escape($this->input->post('postcode'));
        $locatie->gemeente = html_escape($this->input->post('gemeente'));
        $locatie->zaal = html_escape($this->input->post('zaal'));
        $locatie->land = html_escape($this->input->post('land'));
        $locatie->extraInfo = html_escape($this->input->post('extraInfo'));
        $locatie->id = html_escape($this->input->post('id'));

        $this->load->model('locatie_model');
        $this->locatie_model->update($locatie);

        return $this->beheren();
    }

    /**
     * Toont een formulier voor het toevoegen van een nieuwe locatie
     *
     * @author Stef Schoeters
     * @see trainer/locatie_toevoegen
     */

    public function toevoegen()
    {
        $data['titel'] = 'Locatie beheren';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('locatie_model');

        $partials = array(
            'inhoud' => 'trainer/locatie_toevoegen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Maakt een nieuwe locatie aan met de ingevulde gegevens uit het formulier via Locatie_model
     *
     * @author Stef Schoeters
     * @see Locatie::insert()
     */

    public function voegToe()
    {
        $locatie = new stdClass();

        $locatie->naam = html_escape($this->input->post('naam'));
        $locatie->straat = html_escape($this->input->post('straat'));
        $locatie->nr = html_escape($this->input->post('nr'));
        $locatie->postcode = html_escape($this->input->post('postcode'));
        $locatie->gemeente = html_escape($this->input->post('gemeente'));
        $locatie->zaal = html_escape($this->input->post('zaal'));
        $locatie->land = html_escape($this->input->post('land'));
        $locatie->extraInfo = html_escape($this->input->post('extraInfo'));
        $locatie->id = html_escape($this->input->post('id'));

        $this->load->model('locatie_model');
        $this->locatie_model->insert($locatie);

        return $this->beheren();
    }

    /**
     * Verwijderd de locatie met id=$id via Locatie_model
     * met al dan niet een error in de view trainer/locatie_beheren.php
     *
     * @author Stef Schoeters
     * @param $id De id van de locatie dat verwijderd wordt
     * @see Locatie_model::delete()
     * @see Locatie_model::getAll()
     * @see trainer/locatie_beheren.php
     */

    public function verwijder($id)
    {
        $this->load->model('locatie_model');
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['error'] = $this->locatie_model->delete($id);

        $data['titel'] = 'Locaties beheren';
        $data['persoon'] = $this->authex->getPersoonInfo();

        $data['locaties'] = $this->locatie_model->getAll();

        $partials = array(
            'inhoud' => 'trainer/locatie_beheren',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    public function haalJsonOp_Locaties()
    {
        $locatie = new stdClass();

        $locatie->naam = $this->input->get('naam');
        $locatie->straat = $this->input->get('straat');
        $locatie->nr = $this->input->get('nr');
        $locatie->postcode = $this->input->get('postcode');
        $locatie->gemeente = $this->input->get('gemeente');
        $locatie->zaal = $this->input->get('zaal');
        $locatie->land = $this->input->get('land');
        $locatie->extraInfo = $this->input->get('extraInfo');

        $this->load->model('locatie_model');
        $this->locatie_model->insert($locatie);

        $locaties = $this->locatie_model->getAll();

        echo json_encode($locaties);
    }
}
