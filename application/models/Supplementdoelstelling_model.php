<?php

/**
 * @class Supplementdoelstelling_model
 * @brief Model-klasse voor supplementdoelstellingen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel supplementdoelstelling
 */
class Supplementdoelstelling_model extends CI_Model
{
    /**
     * Constructor
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel supplementdoelstelling
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */

    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('supplementdoelstelling');
        return $query->row();
    }

    /**
     * Retourneert alle records uit de tabel supplementdoelstelling
     * @return Alle records
     */

    public function getAll()
    {
        $this->db->order_by('doelstelling', 'asc');
        $query = $this->db->get('supplementdoelstelling');
        return $query->result();
    }

    /**
     * Update het record in de tabel supplementdoelstelling met de id die uit $supplementdoelstelling gehaald wordt
     * @param $supplementdoelstelling Het record waarmee we een bestaand record willen vervangen
     */

    public function update($supplementdoelstelling)
    {
        $this->db->where('id', $supplementdoelstelling->id);
        $this->db->update('supplementdoelstelling', $supplementdoelstelling);
    }

    /**
     * Verwijdert het record in de tabel supplementdoelstelling', $supplementdoelstelling met de id=$id
     * @param $id De id van het record dat verwijderd zal worden
     */


    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('supplementdoelstelling');
    }

    /**
     * Voegt een nieuw record supplementdoelstelling=$supplementdoelstelling', $supplementdoelstelling toe in de tabel supplementdoelstelling', $supplementdoelstelling
     * @param $supplementdoelstelling ', $supplementdoelstelling Het nieuwe record dat toegevoegd zal worden
     * @return De id van het nieuw toegevoegde record
     */

    public function insert($supplementdoelstelling)
    {
        $this->db->insert('supplementdoelstelling', $supplementdoelstelling);
        return $this->db->insert_id();
    }


}
