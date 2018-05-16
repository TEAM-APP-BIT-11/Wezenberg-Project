<?php

/**
 * @class Evenementtype_model
 * @brief Model-klasse voor evenementtypeen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel evenementtype
 */
class Evenementtype_model extends CI_Model
{
    /**
     * Constructor
     */

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel evenementtype
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('evenementtype');
        return $query->row();
    }

    /**
     * Retourneert alle records uit de tabel evenementtype
     * @return Alle records
     */

    function getAll()
    {
        $query = $this->db->get('evenementtype');
        return $query->result();
    }

    /**
     * Update het record in de tabel evenementtype met de id die uit $evenementtype gehaald wordt
     * @param $evenementtype Het record waarmee we een bestaand record willen vervangen
     */

    function update($evenementtype)
    {
        $this->db->where('id', $evenementtype->id);
        $this->db->update('evenementtype', $evenementtype);
    }

    /**
     * Verwijdert het record in de tabel evenementtype', $evenementtype met de id=$id
     * @param $id De id van het record dat verwijderd zal worden
     */


    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db - delete('evenementtype', $evenementtype);
    }

    /**
     * Voegt een nieuw record evenementtype=$evenementtype', $evenementtype toe in de tabel evenementtype', $evenementtype
     * @param $evenementtype ', $evenementtype Het nieuwe record dat toegevoegd zal worden
     * @return De id van het nieuw toegevoegde record
     */

    function insert($evenementtype)
    {
        $this->db->insert('evenementtype', $evenementtype);
        return $this->db->insert_id();
    }

}

?>
