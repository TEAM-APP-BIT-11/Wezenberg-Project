<?php

/**
 * @class Resultaat_model
 * @brief Model-klasse voor resultaaten
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel resultaat
 */
class Resultaat_model extends CI_Model
{
    /*
    * Constructor
    */

    public function __construct()
    {
        parent::__construct();
    }

    /*
    * Retourneert het record met id=$id uit de tabel resultaat
    * @param $id De id van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */


    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('resultaat');
        return $query->row();
    }

    /*
    * Retourneert alle records uit de tabel resultaat
    * @return Alle records
    */

    public function getAll()
    {
        $query = $this->db->get('resultaat');
        return $query->result();
    }

    /*
    * Update het record in de tabel resultaat met de id die uit $resultaat gehaald wordt
    * @param $resultaat Het record waarmee we een bestaand record willen vervangen
    */


    public function update($resultaat)
    {
        $this->db->where('id', $resultaat->id);
        $this->db->update('resultaat', $resultaat);
    }

    /*
    * Verwijdert het record in de tabel resultaat', $resultaat met de id=$id
    * @param $id De id van het record dat verwijderd zal worden
    */


    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('resultaat', $resultaat);
    }

    /*
    * Voegt een nieuw record resultaat=$resultaat', $resultaat toe in de tabel resultaat', $resultaat
    * @param $resultaat', $resultaat Het nieuwe record dat toegevoegd zal worden
    * @return De id van het nieuw toegevoegde record
    */


    public function insert($resultaat)
    {
        $this->db->insert('resultaat', $resultaat);
        return $this->db->insert_id();
    }


    public function getWithRondetypeById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('resultaat');
        $resultaat = $query->row();

        $this->load->model('rondetype_model');


        $resultaat->rondetype = $this->rondetype_model->get($resultaat->rondeTypeId);

        return $resultaat;
    }
}
