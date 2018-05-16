<?php

/**
 * @class Status_model
 * @brief Model-klasse voor statusen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel status
 */
class Status_model extends CI_Model
{
    /**
     * Constructor
     */

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel status
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('status');
        return $query->row();
    }

    /**
     * Retourneert alle records uit de tabel status
     * @return Alle records
     */

    function getAll()
    {
        $query = $this->db->get('status');
        return $query->result();
    }

    /**
     * Update het record in de tabel status met de id die uit $status gehaald wordt
     * @param $status Het record waarmee we een bestaand record willen vervangen
     */

    function update($status)
    {
        $this->db->where('id', $status->id);
        $this->db->update('status', $status);
    }

    /**
     * Verwijdert het record in de tabel status', $status met de id=$id
     * @param $id De id van het record dat verwijderd zal worden
     */


    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db - delete('status', $status);
    }

    /**
     * Voegt een nieuw record status=$status', $status toe in de tabel status', $status
     * @param $status ', $status Het nieuwe record dat toegevoegd zal worden
     * @return De id van het nieuw toegevoegde record
     */

    function insert($status)
    {
        $this->db->insert('status', $status);
        return $this->db->insert_id();
    }

}

?>
