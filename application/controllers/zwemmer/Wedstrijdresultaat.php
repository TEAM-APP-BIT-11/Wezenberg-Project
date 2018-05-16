<?php

  /**
   * @class wedstrijdresultaat
   * @brief Controller-klasse voor Resultaten bekijken van de zwemmer
   * @author Stef Schoeters
   *
   * Controller-klasse met alle methoden die gebruikt worden in de Resultaten bekijken pagina van de zwemmer
   */

class wedstrijdresultaat extends CI_Controller
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
            if ($persoon->typePersoon->typePersoon !== "zwemmer") {
                redirect('');
            }
        }

        $this->load->helper('form');
        $this->load->helper('notation');
    }

    /**
     * Haalt al de bestaande wedstrijden die resultaten hebben op via wedstrijddeelname_model en toont het resulterende object in de view zwemmer/persoonlijke_resultaten.php
     *
     * @author Stef Schoeters
     * @see Wedstrijddeelname_model::getAllWithWedstrijdByPersoon()
     * @see zwemmer/persoonlijke_resultaten.php
     */

    public function bekijken()
    {
        $persoon = $this->authex->getPersoonInfo();
        $data['eindverantwoordelijke'] = "Stef Schoeters";

        $data['titel']  = 'Persoonlijke wedstrijdresultaten bekijken';

        $this->load->model('wedstrijddeelname_model');
        $data['wedstrijddeelnames'] = $this->wedstrijddeelname_model->getAllWithWedstrijdByPersoon($persoon->id);

        $partials = array(
            'inhoud' => 'zwemmer/persoonlijke_resultaten',
            'footer' => 'main_footer');

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Haalt al de resultaten van een bepaalde wedstrijd op via wedstrijdreeks_model, wedstrijddeelname_model en toont het resulterende object in de view zwemmer/ajax_haalResultatenOp.php
     *
     * @author Stef Schoeters
     * @see Wedstrijdreeks_model::getAllWithWedstrijdSlagAfstandById()
     * @see Wedstrijddeelname_model::getAllWithWedstrijdAndResultaatByPersoon()
     * @see zwemmer/ajax_haalResultatenOp.php
     */

    public function haalAjaxOp_Resultaten()
    {
        $persoon = $this->authex->getPersoonInfo();
        $wedstrijdId = $this->input->get('id');

        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijddeelname_model');

        $wedstrijdreeksen = $this->wedstrijdreeks_model->getAllWithWedstrijdSlagAfstandById($wedstrijdId);
        $data['wedstrijdreeksen'] = $wedstrijdreeksen;
        $data['wedstrijddeelnames'] = $this->wedstrijddeelname_model->getAllWithWedstrijdAndResultaatByPersoon($persoon->id, $wedstrijdreeksen);

        $this->load->view("zwemmer/ajax_haalResultatenOp", $data);
    }
}
