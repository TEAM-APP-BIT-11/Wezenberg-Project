<?php

/**
 * @class Wedstrijddeelname_model
 * @brief Model-klasse voor wedstrijddeelnameen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel wedstrijddeelname
 */
class Wedstrijddeelname_model extends CI_Model
{
    /*
    * Constructor
    */

    public function __construct()
    {
        parent::__construct();
    }

    /*
    * Retourneert het record met id=$id uit de tabel wedstrijddeelname
    * @param $id De id van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */

    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('wedstrijddeelname');
        return $query->row();
    }

    /*
    * Retourneert het record met resultaatId=$id uit de tabel wedstrijddeelname
    * @param $id De resultaatId van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */

    public function getByResultaatId($id)
    {
        $this->db->where('resultaatId', $id);
        $query = $this->db->get('wedstrijddeelname');
        return $query->row();
    }

    /*
    * Retourneert alle records uit de tabel wedstrijddeelname
    * @return Alle records
    */

    public function getAll()
    {
        $query = $this->db->get('wedstrijddeelname');
        return $query->result();
    }

    /*
     * Retourneert alle wedstrijddeelnames uit de tabel wedstrijddeelname voor de persoon met id=$persoonID, inclusief de bijhorende status
     * @param $persoonId De id van de persoon waarvoor de wedstrijddeelnames opgehaald worden
     * @return De opgevraagde wedstrijddeelnames met status
     */

    public function getAllForPersoonWithStatus($persoonId)
    {
        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('wedstrijddeelname');
        $wedstrijddeelnames = $query->result();

        $this->load->model('status_model');

        foreach ($wedstrijddeelnames as $wedstrijddeelname) {
            $wedstrijddeelname->status = $this->status_model->get($wedstrijddeelname->statusId);
        }

        return $wedstrijddeelnames;
    }

    /*
    * Update het record in de tabel wedstrijddeelname met de id die uit $wedstrijddeelname gehaald wordt
    * @param $wedstrijddeelname Het record waarmee we een bestaand record willen vervangen
    */

    public function update($wedstrijddeelname)
    {
        $this->db->where('id', $wedstrijddeelname->id);
        $this->db->update('wedstrijddeelname', $wedstrijddeelname);
    }

    /*
    * Verwijdert het record in de tabel wedstrijddeelname', $wedstrijddeelname met de id=$id
    * @param $id De id van het record dat verwijderd zal worden
    */


    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('wedstrijddeelname');
    }

    /*
    * Voegt een nieuw record wedstrijddeelname=$wedstrijddeelname', $wedstrijddeelname toe in de tabel wedstrijddeelname', $wedstrijddeelname
    * @param $wedstrijddeelname', $wedstrijddeelname Het nieuwe record dat toegevoegd zal worden
    * @return De id van het nieuw toegevoegde record
    */

    public function insert($wedstrijdDeelname)
    {
        $this->db->insert('wedstrijddeelname', $wedstrijdDeelname);
        var_dump($wedstrijdDeelname);
        //echo($this->db->insert_id());
        return $this->db->insert_id();
    }

    public function getAllAndWedstrijdenWhereResultaatIsNotNull()
    {
        $this->db->where('resultaatId IS NOT NULL');
        $query = $this->db->get('wedstrijddeelname');
        return $query->result();

        $this->load->model('wedstrijdreeks_model');

        $wedstrijden = $this->wedstrijdreeks_model->getAllWithWedstrijdenAndSlagAndAfstand();

        foreach ($wedstrijden as $wedstrijd) {
            $wedstrijddeelname->wedstrijd = $wedstrijd;
        }
    }

    public function getAllByPersoonAndWedstrijdenWhereResultaatIsNotNull($persoonId)
    {
        $this->db->where('resultaatId IS NOT NULL');
        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('wedstrijddeelname');
        $deelnamens = $query->result();

        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijd');


        $wedstrijden = $this->wedstrijdreeks_model->getAllWithWedstrijdenAndSlagAndAfstand();

        foreach ($deelnamens as $deelname) {
            $deelname->wedstrijd = $wedstrijd;
        }
    }

    public function getAllByDeelname($persoonId)
    {
        $this->db->where('persoonId', $persoonId);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('wedstrijddeelname');
        return $query->result();
    }

    public function getDeelnamesPersoonReeks()
    {
        $this->db->order_by('persoonId', 'asc');
        $query = $this->db->get('WedstrijdDeelname');
        $deelnames = $query->result();

        $this->load->model('persoon_model');
        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijd_model');

        foreach ($deelnames as $deelname) {
            $deelname->persoon = $this->persoon_model->get($deelname->persoonId);
            $deelname->reeks = $this->wedstrijdreeks_model->get($deelname->wedstrijdReeksId);
            $deelname->naam = $this->wedstrijd_model->get($deelname->reeks->wedstrijdId);
        }

        return $deelnames;
    }

    public function getAllByReeks($wedstrijdReeksId)
    {

        $controleren = array('wedstrijdreeksId' => $wedstrijdReeksId, 'statusId' => 1);
        $this->db->where($controleren);
        $this->db->order_by('persoonId', 'asc');
        $query = $this->db->get('wedstrijdDeelname');
        return $query->result();
    }

    public function getAllWithPersoonResultaatById($reeksId)
    {
        $this->db->where('wedstrijdReeksId', $reeksId);
        $query = $this->db->get('wedstrijddeelname');
        $wedstrijddeelnames = $query->result();

        $this->load->model('persoon_model');
        $this->load->model('resultaat_model');


        foreach ($wedstrijddeelnames as $wedstrijddeelname) {
            $wedstrijddeelname->persoon = $this->persoon_model->get($wedstrijddeelname->persoonId);
            $wedstrijddeelname->resultaat = $this->resultaat_model->getWithRondetypeById($wedstrijddeelname->resultaatId);
        }
        return $wedstrijddeelnames;
    }

    public function getAllWithWedstrijdByPersoon($persoonId)
    {

        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('wedstrijddeelname');
        $wedstrijddeelnames = $query->result();

        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijd_model');

        foreach ($wedstrijddeelnames as $wedstrijddeelname) {
            $wedstrijddeelname->wedstrijdreeks = $this->wedstrijdreeks_model->get($wedstrijddeelname->wedstrijdReeksId);
            $wedstrijdId = $wedstrijddeelname->wedstrijdreeks->wedstrijdId;
            $wedstrijddeelname->wedstrijd = $this->wedstrijd_model->get($wedstrijdId);

        }
        return $wedstrijddeelnames;
    }

    public function getAllWithWedstrijdAndResultaatByPersoon($persoonId, $wedstrijdreeksen)
    {
        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('wedstrijddeelname');
        $wedstrijddeelnames = $query->result();

        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijd_model');
        $this->load->model('resultaat_model');

        foreach ($wedstrijddeelnames as $wedstrijddeelname) {
            foreach ($wedstrijdreeksen as $wedstrijdreeks) {
                if ($wedstrijdreeks->id == $wedstrijddeelname->wedstrijdReeksId) {
                    $wedstrijddeelname->wedstrijdreeks = $this->wedstrijdreeks_model->get($wedstrijddeelname->wedstrijdReeksId);
                    $wedstrijddeelname->resultaat = $this->resultaat_model->getWithRondetypeById($wedstrijddeelname->resultaatId);
                }
            }
        }
        return $wedstrijddeelnames;
    }

    public function getAllByPersoonAndStatus2WithWedstrijd($persoonId)
    {
        $this->db->where('persoonId', $persoonId);
        $this->db->where('statusId', 2);
        $query = $this->db->get('wedstrijddeelname');
        $wedstrijddeelnames = $query->result();
        

        $this->load->model('wedstrijdreeks_model');
        $this->load->model('wedstrijd_model');
        $this->load->model('locatie_model');

        foreach ($wedstrijddeelnames as $wedstrijddeelname) {
            $wedstrijddeelname->wedstrijdreeks = $this->wedstrijdreeks_model->get($wedstrijddeelname->wedstrijdReeksId);
            $wedstrijddeelname->wedstrijd = $this->wedstrijd_model->get($wedstrijddeelname->wedstrijdreeks->wedstrijdId);
            $wedstrijddeelname->wedstrijd->locatie = $this->locatie_model->get($wedstrijddeelname->wedstrijd->locatieId);
        }
        return $wedstrijddeelnames;
    }
	public function getDeelnamensResultaten(){
        $query = $this->db->get('wedstrijddeelname');
        $wedstrijddeelnamens = $query->result();
        
        $this->load->model('resultaat_model');
        
        foreach($wedstrijddeelnamens as $deelname)
        {
            if($deelname->resultaatId != NULL)
            {
                $deelname->resultaat = $this->resultaat_model->getWithRondetypeById($deelname->resultaatId);
            }
            
        }
        return $wedstrijddeelnamens;
    }


}
