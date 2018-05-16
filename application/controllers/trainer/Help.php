<?php
/**
 * @class help
 * @brief Controller-klasse voor Help van de trainer
 * @author Stef Schoeters & Senne Cools
 *
 * Controller-klasse met alle methoden die gebruikt worden in de Help pagina van de trainer
 */

class Help extends CI_Controller
{
  /**
  * Contructor
  */

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('html');

        if (!$this->authex->isAangemeld()) {
            redirect('Algemeen/logIn');
        } else {
            $persoon = $this->authex->getPersoonInfo();
            if ($persoon->typePersoon->typePersoon != "trainer") {
                redirect('Algemeen/logIn');
            }
        }

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /**
     * Toont de help view
     * @author Stef Schoeters & Senne Cools
     * @see trainer/help.php
     */

    public function index()
    {
        $data['titel'] = 'Help functie';
        $data['eindverantwoordelijke'] = "Stef Schoeters en Senne Cools";
        $persoon = $this->authex->getPersoonInfo();

        $partials = array(
            'inhoud' => 'trainer/help',
            'footer' => 'main_footer');

        $this->template->load('main_help', $partials, $data);
    }
}
