<?php

/**
 * @class Wedstrijdreeks_model
 * @brief Model-klasse voor wedstrijdreeksen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel wedstrijdreeks
 */
class Wedstrijdreeks_model extends CI_Model
{
    /*
    * Constructor
    */

    public function __construct()
    {
        parent::__construct();
    }

    /*
    * Retourneert het record met id=$id uit de tabel wedstrijdreeks
    * @param $id De id van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */

    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('wedstrijdreeks');
        return $query->row();
    }

    /**
     * Retourneert het record met id=$id uit de tabel wedstrijdreeks
     * Samen met slag, afstand en wedstrijd
     * @param $id De id van het record dat wordt opgevraagd
     * @return Het opgevraagde record met slag, afstand en wedstrijd
     * @author Neil Van den Broeck
     */

    public function getWithWedstrijdSlagAfstand($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeks = $query->row();

        $this->load->model('slag_model');
        $this->load->model('afstand_model');
        $this->load->model('wedstrijd_model');

        $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
        $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
        $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);

        return $wedstrijdreeks;
    }

    /*
    * Retourneert alle records uit de tabel wedstrijdreeks
    * @return Alle records
    */

    public function getAll()
    {
        $query = $this->db->get('wedstrijdreeks');
        return $query->result();
    }

    /*
     * Retourneert alle records uit de tabel wedstrijdreeks met bijhorende wedstrijd, slag en afstand
     * @return Alle records inclusief bijhorende wedstrijd, slag en afstand
     */

    public function getAllWithWedstrijdSlagAfstand()
    {
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

        $this->load->model('slag_model');
        $this->load->model('afstand_model');
        $this->load->model('wedstrijd_model');

        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
            $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
        }
        return $wedstrijdreeksen;
    }

    /*
     * Retourneert de records uit de tabel wedstrijdreeks met bijhorende slag en afstand voor de persoon met id=$persoonId die deelneemt aan de wedstrijd met id=$wedstrijdId
     * @param $persoonId De id van de persoon waarvoor records opgehaald worden
     * @param $wedstrijdId De id van de wedstrijd waaraan de persoon waarvoor records opgehaald worden deelneemt
     * @return De gevraagde records
     */

    public function getAllWithWedstrijdSlagAfstandAndDeelnamePersoon($persoonId, $wedstrijdId)
    {
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

        $this->load->model('slag_model');
        $this->load->model('afstand_model');
        $this->load->model('wedstrijd_model');
        $this->load->model('wedstrijddeelname_model');
        $this->load->model('resultaat_model');

        $deelnames = $this->wedstrijddeelname_model->getAllForPersoonWithStatus($persoonId);

        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
            $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
            foreach ($deelnames as $deelname) {
                if ($wedstrijdreeks->wedstrijdId == $wedstrijdId) {
                    $wedstrijdreeks->deelname = $deelname;
                    $wedstrijdreeks->resultaat = $this->resultaat_model->get($deelname->resultaatId);
                } else {
                    $wedstrijdreeks->resultaat = "Geen resultaat";
                }
            }
        }
        return $wedstrijdreeksen;
    }

    /*
    * Update het record in de tabel wedstrijdreeks met de id die uit $wedstrijdreeks gehaald wordt
    * @param $wedstrijdreeks Het record waarmee we een bestaand record willen vervangen
    */

    public function update($wedstrijdreeks)
    {
        $this->db->where('id', $wedstrijdreeks->id);
        $this->db->update('wedstrijdreeks', $wedstrijdreeks);
    }

    /*
    * Verwijdert het record in de tabel wedstrijdreeks', $wedstrijdreeks met de id=$id
    * @param $id De id van het record dat verwijderd zal worden
    */


    public function delete($id)
    {
        $this->load->model('wedstrijddeelname_model');
        $deelnames = $this->wedstrijddeelname_model->getAllWithReeks($id);

        if(!empty($deelnames)){
          foreach($deelnames as $deelname){
            var_dump($deelname);
            $this->wedstrijddeelname_model->delete($deelname->id);
          }
          $this->db->where('id', $id);
          $this->db->delete('wedstrijdreeks');
        }else{
          $this->db->where('id', $id);
          $this->db->delete('wedstrijdreeks');
        }
    }

    /*
    * Voegt een nieuw record wedstrijdreeks=$wedstrijdreeks', $wedstrijdreeks toe in de tabel wedstrijdreeks', $wedstrijdreeks
    * @param $wedstrijdreeks', $wedstrijdreeks Het nieuwe record dat toegevoegd zal worden
    * @return De id van het nieuw toegevoegde record
    */

    public function insert($wedstrijdreeks)
    {
        $this->db->insert('wedstrijdreeks', $wedstrijdreeks);
        return $this->db->insert_id();
    }

    /**
     * Haalt alle wedstrijdreeksen, de slagen en de afstanden hiervan, op waarbij de wedstrijdId = $id
     * @author Dieter Verboven
     * @param $id
     * @return mixed
     *
     */

    public function getAllWithWedstrijdSlagAfstandById($wedstrijdId)
    {
        $this->db->where('wedstrijdId', $wedstrijdId);

        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

        $this->load->model('slag_model');
        $this->load->model('afstand_model');
        $this->load->model('wedstrijd_model');

        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
            $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
        }
        return $wedstrijdreeksen;
    }

    

    /*
    * Retourneert alle records uit de tabel wedstrijdreeks, wedstrijd, slag en afstand
    * @return Alle records
    */

    public function getAllWithWedstrijdenAndSlagAndAfstand()
    {
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

        $this->load->model('wedstrijd_model');
        $this->load->model('slag_model');
        $this->load->model('afstand_model');

        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
            $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
        }

        return $wedstrijdreeksen;
    }

    /**
     * Haalt wedstrijdreeks op waar id=$id uit de tabel wedstrijdreeks
     * @author Neil Van den Broeck
     * @param $id
     * @return mixed
     *
     */

    public function getWithWedstrijd($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeks = $query->row();
        $this->load->model('wedstrijd_model');
        $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);

        return $wedstrijdreeks;
    }

    /**
     * Haalt wedstrijdreeks, slag en afstand op waar id=$id uit de tabellen wedstrijdreeks, slag en afstand
     * @author Dieter Verboven
     * @param $id
     * @return slag, afstand en info van de wedstrijdreeks van de meegegeven id
     *
     */

    public function getWithWedstrijdAndSlagAndAfstand($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeks = $query->row();

        $this->load->model('wedstrijd_model');
        $this->load->model('slag_model');
        $this->load->model('afstand_model');

        $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
        $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
        $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);

        return $wedstrijdreeks;
    }

    public function getAllFromWedstrijdSlagAfstandAndDeelnamePersoon($persoonId, $wedstrijdId)
    {
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

        $this->load->model('slag_model');
        $this->load->model('afstand_model');
        $this->load->model('wedstrijd_model');
        $this->load->model('wedstrijddeelname_model');

        $deelnames = $this->wedstrijddeelname_model->getAllForPersoonWithStatus($persoonId);

        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
            $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
            foreach ($deelnames as $deelname) {
                if ($deelname->wedstrijdReeksId == $wedstrijdreeks->id) {
                    $wedstrijdreeks->deelname = $deelname;
                }
            }
        }
        return $wedstrijdreeksen;
    }
/**
   
     * Geeft alle wedstrijdreeksen met de overeenkomstige slag, afstand en wedstrijd. uit de tabel wedstrijdreeks Ook de overeenkomstige wedstrijddeelnamens worden gegeven uit de tabel wedstrijddeelname.
 
     * @return geeft de wedstrijdreeksen met slag, afstand, wedstrijd en wedstrijddeelnamens terug.
     * @author Ruben Tuytens
     * @see Wedstrijddeelname_model::getAllByReeks()
     * @see Slag_model::get()
     * @see Afstand_model::get()
     * @see Wedstrijd_model::get()
     */
    public function getAlles()
    {
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

        $this->load->model('slag_model');
        $this->load->model('afstand_model');
        $this->load->model('wedstrijd_model');
        $this->load->model('wedstrijddeelname_model');


        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->deelnames = $this->wedstrijddeelname_model->getAllByReeks($wedstrijdreeks->id);


            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
            $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
        }
        return $wedstrijdreeksen;
    }
/**
     * Geeft de wedstrijdreeksen weer voor een wedstrijd wedstrijdId = $wedstrijdId en ook de bijhorende slag en afstand uit de tabel wedstrijdreeks
     * @param $wedstrijdId id van de wedstrijd waar er wedstrijdreeksen van moeten opgehaald worden
     * @return wedstrijdreeksen met slag en afstand
     * @author Ruben Tuytens
     * @see Slag_model::get()
     * @see Afstand_model::get()
    
     */

    public function getReeksenSlag($wedstrijdId)
    {
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

        $this->load->model('slag_model');
        $this->load->model('afstand_model');

        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
        }
        return $wedstrijdreeksen;
    }
   
 /**
     * Geeft de wedstrijdreeksen weer voor een wedstrijd wedstrijdId = $wedstrijdId waar ook de slagId = $slagId en de bijhorende afstand records
     * @param $wedstrijdId id van de wedstrijd waar er wedstrijdreeksen van moeten opgehaald worden
     * @param $slagId id van de slag waar er wedstrijdreeksen van moeten opgehaald worden
     * @return wedstrijdreeksen met afstand gefilterd op wedstrijd en slag 
     * @author Ruben Tuytens
     * @see Afstand_model::get()
    
     */   
	public function getAllAfstandenForSlag($slagId, $wedstrijdId)
    {
        $this->db->where('wedstrijdId', $wedstrijdId);
        $this->db->where('slagId', $slagId);
        $query = $this->db->get('wedstrijdreeks');
        
        $afstanden = $query->result();
        
        $this->load->model('afstand_model');
        
        foreach($afstanden as $afstand)
        {
            $afstand->afstand = $this->afstand_model->get($afstand->afstandId);
        }
        
        return $afstanden;
        
    }
    
/**
     * Geeft de wedstrijdreeks weer voor een wedstrijd wedstrijdId = $wedstrijdId waar ook de slagId = $slagId en de afstandId = $afstandId uit de tabel wedstrijdreeks
     * @param $wedstrijdId id van de wedstrijd waar er een wedstrijdreeks van moeten opgehaald worden
     * @param $afstandId id van de afstand waar er een wedstrijdreeks van moeten opgehaald worden
     * @param $slagId id van de slag waar er een wedstrijdreeks van moeten opgehaald worden
     * @return opgevraagde wedstrijdreeks record
     * @author Ruben Tuytens
    
     */    
	 public function getWedstrijdreeks($wedstrijdId, $afstandId, $slagId)
    {
        $this->db->where('wedstrijdId', $wedstrijdId);
        $this->db->where('slagId', $slagId);
        $this->db->where('afstandId', $afstandId);
        $query = $this->db->get('wedstrijdreeks');
        return $query->row();
      
    }
}
