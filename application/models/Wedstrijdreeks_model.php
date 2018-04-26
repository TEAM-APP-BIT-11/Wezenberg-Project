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
        $this->db->where('id', $id);
        $this->db->delete('wedstrijdreeks');
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


    //nieuwe functie
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

    public function getAllWithWedstrijdSlagAfstandResultaatRankingById($persoonId, $wedstrijdId)
    {
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

        $this->load->model('slag_model');
        $this->load->model('afstand_model');
        $this->load->model('wedstrijd_model');
        $this->load->model('wedstrijddeelname_model');
        $this->load->model('resultaat_model');

        $deelnamens = $this->wedstrijddeelname_model->getAll();


        foreach ($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
            $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
            foreach ($deelnamens as $deelname) {
                if ($wedstrijdreeks->id == $deelname->wedstrijdReeksId && $deelname->persoonId == $persoonId) {
                    // $wedstrijdreeksen->resultaat = $this->resultaat_model->get($deelname->resultaatId);
                    $wedstrijdreeks->ranking = $deelname->ranking;
                }

            }
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
	public function getAlles(){
      
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
    
    
    public function getReeksenSlag($wedstrijdId)
    {
        $this->db->where('wedstrijdId', $wedstrijdId);
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();
        
        $this->load->model('slag_model');
        $this->load->model('afstand_model');
        
        foreach ($wedstrijdreeksen as $wedstrijdreeks)
        {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
        }
        return $wedstrijdreeksen;
    }
}
