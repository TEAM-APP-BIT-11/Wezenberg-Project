<?php
/**
 * @class Wedstrijdreeks
 * @brief Controller-klasse voor Wedstrijdreeks beheren van de trainer
 * @author Stef Schoeters
 *
 * Controller-klasse met alle methoden die gebruikt worden in de Wedstrijdreeks beheren pagina van de trainer
 */

class Wedstrijdreeks extends CI_Controller
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
     * Toont een formulier voor het toevoegen van een nieuwe Wedstrijdreeks
     * en haalt de slagen, afstanden en wedstrijd via id=$id op via Slag_model, Afstand_model en Wedstrijd_model en toont de resulterende objecten
     *
     * @author Stef Schoeters
     * @see Slag_model::getAll()
     * @see Afstand_model::getAll()
     * @see Wedstrijd_model::get()
     * @see trainer/wedstrijdreeks_toevoegen.php
     */

    public function toevoegen($id)
    {
        $data['titel'] = 'Wedstrijd reeks toevoegen';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();

        $this->load->model('wedstrijd_model');
        $data['wedstrijd'] = $this->wedstrijd_model->get($id);

        $partials = array('inhoud' => 'trainer/wedstrijdreeks_toevoegen',
        'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Maakt een wedstrijdreeks aan met de gegevens uit het formulier via Wedstrijdreeks_model
     *
     * @author Stef Schoeters
     * @see Wedstrijdreeks_model::insert()
     * @see trainer/wedstrijdreeks_toevoegen.php
     */

    public function aanmaken()
    {
      $wedstrijdreeks = new stdClass();

      $wedstrijdreeks->datum = html_escape($this->input->post('reeksDatum'));
      $wedstrijdreeks->beginuur = html_escape($this->input->post('reeksBeginuur'));
      $wedstrijdreeks->einduur = html_escape($this->input->post('reeksEinduur'));
      $wedstrijdreeks->afstandId = html_escape($this->input->post('afstand'));
      $wedstrijdreeks->slagId = html_escape($this->input->post('slag'));
      $wedstrijdId = html_escape($this->input->post('id'));
      $wedstrijdreeks->wedstrijdId = $wedstrijdId;
      $this->load->model('wedstrijdreeks_model');
      $wedstrijdreeks = $this->wedstrijdreeks_model->insert($wedstrijdreeks);
      $data['id'] = $wedstrijdreeks;

      redirect('trainer/Wedstrijd/aanpassen/'. $wedstrijdId .'');
    }

    /**
     * Haalt de wedstrijdreeks met id=$id (en slag, afstand) op via Wedstrijdreeks_model, Slag_model, Afstand_model en toont het resulterende object in de view trainer/wedstrijdreeks_aanpassen.php
     *
     * @param $id De id van de wedstrijd dat getoond wordt
     * @see Wedstrijdreeks_model::getWithWedstrijd()
     * @see slag_model::getAll()
     * @see afstand_model::getAll()
     * @see trainer/wedstrijdreeks_aanpassen.php
     */

    public function aanpassen($id)
    {
        $data['titel'] = 'Wedstrijd aanpassen';
        $data['eindverantwoordelijke'] = "Stef Schoeters";
        $data['persoon'] = $this->authex->getPersoonInfo();

        $this->load->model('wedstrijdreeks_model');
        $data['wedstrijdreeks'] = $this->wedstrijdreeks_model->getWithWedstrijd($id);

        $this->load->model('slag_model');
        $data['slagen'] = $this->slag_model->getAll();

        $this->load->model('afstand_model');
        $data['afstanden'] = $this->afstand_model->getAll();

        $partials = array('inhoud' => 'trainer/wedstrijdreeks_aanpassen',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Past een bestaande wedstrijdreeks aan met de aangepaste gegevens uit het formulier via Wedstrijdreeks_model
     *
     * @author Stef Schoeters
     * @param $id De id van de wedstrijd waar de wedstrijdreek van wordt aangepast
     * @see Wedstrijdreeks_model::update()
     * @see trainer/wedstrijdreeks_aanpassen.php
     */

    public function pasAan()
    {
      $wedstrijdreeks = new stdClass();

      $wedstrijdreeks->datum = html_escape($this->input->post('reeksDatum'));
      $wedstrijdreeks->beginuur = html_escape($this->input->post('reeksBeginuur'));
      $wedstrijdreeks->einduur = html_escape($this->input->post('reeksEinduur'));
      $wedstrijdreeks->afstandId = html_escape($this->input->post('afstand'));
      $wedstrijdreeks->slagId = html_escape($this->input->post('slag'));
      $wedstrijdreeks->id = html_escape($this->input->post('id'));
      $wedstrijdreeks->wedstrijdId = html_escape($this->input->post('wedstrijdId'));

      $this->load->model('wedstrijdreeks_model');
      $this->wedstrijdreeks_model->update($wedstrijdreeks);

      redirect('trainer/Wedstrijd/aanpassen/'. $wedstrijdreeks->wedstrijdId .'');
    }

    /**
     * Verwijderd de wedstrijdreeks met id=$id via Wedstrijdreeks_model
     *
     * @author Stef Schoeters
     * @param $id De id van de wedstrijdreeks dat verwijderd wordt
     * @see Wedstrijdreeks_model::delete()
     */

    public function verwijder($id, $wedstrijdId)
    {
      $this->load->model('wedstrijdreeks_model');
      $this->wedstrijdreeks_model->delete($id);

      redirect('trainer/Wedstrijd/aanpassen/'. $wedstrijdId .'');
    }
}
