<?php
/**
 * @class Locatie
 * @brief Controller-klasse voor home van de bezoeker
 * @author Stef Schoeters & Ruben Tuytens
 *
 * Controller-klasse met alle methoden die gebruikt worden in de home van de bezoeker
 */

class Home extends CI_Controller
{
  /**
  * Contructor
  */

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('notation');
    }

    /**
     * Toont de view algemeen/home.php
     *
     * @see algemeen/home.php
     */

    public function index()
    {
        $data['titel'] = 'Welkom bezoeker!';

        $partials = array(
            'inhoud' => 'algemeen/home');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt al de zwemmers op via Persoon_model en toont het resulterende object in de view bezoeker/team_lijst.php
     *
     * @author Stef Schoeters
     * @see Persoon_model::getZwemmers()
     * @see bezoeker/team_lijst.php
     */

    public function team()
    {
        $data['titel'] = 'Team';
        $data['eindverantwoordelijke'] = 'Stef Schoeters';

        $this->load->model('persoon_model');

        $data['zwemmers'] = $this->persoon_model->getZwemmers();


        $partials = array(
            'inhoud' => 'bezoeker/team_lijst',
            'footer' => 'main_footer');

        $this->template->load('main_home', $partials, $data);
    }

    /**
     * Haalt de zwemmer met id=$id op via Persoon_model en toont het resulterende object in de view bezoeker/teamlindsinfo_bekijken.php
     *
     * @author Stef Schoeters
     * @see Persoon_model::get()
     * @see bezoeker/teamlidsinfo_bekijken.php
     */

    public function zwemmer($id)
    {
        $this->load->model('persoon_model');

        $zwemmer = $this->persoon_model->get($id);

        $data['eindverantwoordelijke'] = 'Stef Schoeters';
        $data['titel'] = 'ZwemmerInfo - ' . $zwemmer->voornaam;
        $data['zwemmer'] = $zwemmer;


        $partials = array(
            'inhoud' => 'bezoeker/teamlidsinfo_bekijken',
            'footer' => 'main_footer');

        $this->template->load('main_home', $partials, $data);
    }

    public function resultaten()
    {
        $this->load->model('wedstrijd_model');
        $data['eindverantwoordelijke'] = "Ruben Tuytens";
        $data['titel'] = 'Resultaten van de wedstrijden bekijken';

        $data['wedstrijden'] = $this->wedstrijd_model->getAll();

        $partials = array(
            'inhoud' => 'bezoeker/wedstrijd_resultaat', 'footer' => 'main_footer');

        $this->template->load('main_home', $partials, $data);
    }

    public function resultaatDetail($id)
    {
        $data['eindverantwoordelijke'] = "Ruben Tuytens";

        $this->load->model('wedstrijd_model');
        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijddeelname_model');
        $this->load->model('persoon_model');
        $data['wedstrijdnaam'] = $this->wedstrijd_model->get($id);
        $data['personen'] = $this->persoon_model->getAll();

        $data['titel'] = 'Wedstrijd';

        $data['slagen'] = $this->wedstrijdreeks_model->getReeksenSlag($id);
        $data['deelnamens'] = $this->wedstrijddeelname_model->getDeelnamensResultaten();

        $partials = array(
            'inhoud' => 'bezoeker/wedstrijd_details_bezoeker', 'footer' => 'main_footer');

        $this->template->load('main_home', $partials, $data);
    }
}
