<?php

/**
 * @class Voedingssupplement_model
 * @brief Model-klasse voor voedingssupplementen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel voedingssupplement
 */
class Voedingssupplement_model extends CI_Model
{
    /*
    * Constructor
    */

    function __construct()
    {
        parent::__construct();
    }

    /*
    * Retourneert het record met id=$id uit de tabel voedingssupplement
    * @param $id De id van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('voedingssupplement');
        return $query->row();
    }

    function getWithDoelstelling($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('voedingssupplement');
        $voedingssupplement = $query->row();

        $this->load->model('supplementdoelstelling_model');
        $voedingssupplement->doelstelling = $this->supplementdoelstelling_model->get($voedingssupplement->doelstellingId);

        return $voedingssupplement;
    }

    /*
    * Retourneert alle records uit de tabel voedingssupplement
    * @return Alle records
    */

    function getAll()
    {
        $query = $this->db->get('voedingssupplement');
        return $query->result();
    }

    /*
    * Update het record in de tabel voedingssupplement met de id die uit $voedingssupplement gehaald wordt
    * @param $voedingssupplement Het record waarmee we een bestaand record willen vervangen
    */

    function update($voedingssupplement)
    {
        $this->db->where('id', $voedingssupplement->id);
        $this->db->update('voedingssupplement', $voedingssupplement);
    }

    /*
    * Verwijdert het record in de tabel voedingssupplement', $voedingssupplement met de id=$id
    * @param $id De id van het record dat verwijderd zal worden
    */


    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('voedingssupplement');
    }

    /*
    * Voegt een nieuw record voedingssupplement=$voedingssupplement', $voedingssupplement toe in de tabel voedingssupplement', $voedingssupplement
    * @param $voedingssupplement', $voedingssupplement Het nieuwe record dat toegevoegd zal worden
    * @return De id van het nieuw toegevoegde record
    */

    function insert($voedingssupplement)
    {
        $this->db->insert('voedingssupplement', $voedingssupplement);
        return $this->db->insert_id();
    }
    
    function getAllByDoelstelling($doelstellingId)
    {   
        
        $this->db->where('doelstellingId', $doelstellingId);
        $this->db->order_by('Id', 'asc');
        $query = $this->db->get('voedingssupplement');

        return $query->result();
    }
    
    function verwijderAlleSupplementen($doelstellingId)
    {
        $supplementen = $this->db->get('voedingssupplement');
        
        foreach($supplementen as $supplement)
        {
            $this->db->where('doelstellingId', $doelstellingId);
            $this->db->delete('voedingssupplement');
        }
    }
}

?>
