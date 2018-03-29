<?php
/**
* @class Wedstrijd_model
* @brief Model-klasse voor wedstrijden
*
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel wedstrijd
*/
class Wedstrijd_model extends CI_Model
{
    /*
    * Constructor
    */

    public function __construct()
    {
        parent::__construct();
    }

    /*
    * Retourneert het record met id=$id uit de tabel wedstrijd
    * @param $id De id van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */

    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('wedstrijd');
        return $query->row();
    }
		//
    // public function getWithLocatie($id)
    // {
    //     $this->db->where('id', $id);
    //     $query = $this->db->get('wedstrijd');
    //     $wedstrijd = $query->row();
		//
    //     $this->load->model('locatie_model');
    //     $wedstrijd->locatie = $this->locatie_model->get($wedstrijd->locatieId);
		//
    //     return $wedstrijd;
    // }


    /*
    * Retourneert alle records uit de tabel wedstrijd
    * @return Alle records
    */


    public function getAll()
    {
        $query = $this->db->get('wedstrijd');
        return $query->result();
    }

    public function getAllWithLocatie()
    {
        $query = $this->db->get('wedstrijd');
        $wedstrijden = $query->result();

        $this->load->model('locatie_model');

        foreach ($wedstrijden as $wedstrijd) {
            $wedstrijd->locatie = $this->locatie_model->get($wedstrijd->locatieId);
        }

        return $wedstrijden;
    }

    /*
    * Update het record in de tabel wedstrijd met de id die uit $wedstrijd gehaald wordt
    * @param $wedstrijd Het record waarmee we een bestaand record willen vervangen
    */

    public function update($wedstrijd)
    {
        $this->db->where('id', $wedstrijd->id);
        $this->db->update('wedstrijd', $wedstrijd);
    }

    /*
    * Verwijdert het record in de tabel wedstrijd', $wedstrijd met de id=$id
    * @param $id De id van het record dat verwijderd zal worden
    */


    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('wedstrijd');
    }

    /*
    * Voegt een nieuw record wedstrijd=$wedstrijd', $wedstrijd toe in de tabel wedstrijd', $wedstrijd
    * @param $wedstrijd', $wedstrijd Het nieuwe record dat toegevoegd zal worden
    * @return De id van het nieuw toegevoegde record
    */

    public function insert($wedstrijd)
    {
        $this->db->insert('wedstrijd', $wedstrijd);
        return $this->db->insert_id();
    }
}
