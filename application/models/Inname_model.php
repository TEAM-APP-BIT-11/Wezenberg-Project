<?php

/**
 * @class Inname_model
 * @brief Model-klasse voor innameen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel inname
 */
class Inname_model extends CI_Model
{
    /*
    * Constructor
    */

    function __construct()
    {
        parent::__construct();
    }

    /*
    * Retourneert het record met id=$id uit de tabel inname
    * @param $id De id van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('inname');
        return $query->row();
    }

    /*
    * Retourneert alle records uit de tabel inname
    * @return Alle records
    */

    function getAll()
    {
        $query = $this->db->get('inname');
        return $query->result();
    }

    /**
     * Geeft alle innames met hun voedingssupplement (en doelstelling) terug waar datum=$datum en persoonId=$persoonId uit de tabel inname
     * @author Neil Van den Broeck
     * @param $datum datum waarvoor de innames worden opgevraagt
     * @param $persoonId ID van de persoon waarvoor de innames worden opgevraagd
     * @return Innames met voedingssupplement voor een datum voor een persoon.
     * @see \Voedingssupplement_model::getWithDoelstelling()
     */
    function getAllByPersoonAndDateWithVoedingssupplement($datum, $persoonId)
    {
        $this->db->where('persoonId', $persoonId);
        $this->db->where('datum', $datum);
        $query = $this->db->get('inname');
        $innames = $query->result();

        $this->load->model('voedingssupplement_model');

        foreach ($innames as $inname) {
            $inname->voedingssupplement = $this->voedingssupplement_model->getWithDoelstelling($inname->voedingssupplementId);
        }
        return $innames;
    }

    /*
    * Update het record in de tabel inname met de id die uit $inname gehaald wordt
    * @param $inname Het record waarmee we een bestaand record willen vervangen
    */

    function update($inname)
    {
        $this->db->where('id', $inname->id);
        $this->db->update('inname', $inname);
    }

    /*
    * Verwijdert het record in de tabel inname', $inname met de id=$id
    * @param $id De id van het record dat verwijderd zal worden
    */


    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('inname');
    }

    /*
    * Voegt een nieuw record inname=$inname', $inname toe in de tabel inname', $inname
    * @param $inname', $inname Het nieuwe record dat toegevoegd zal worden
    * @return De id van het nieuw toegevoegde record
    */

    function insert($inname)
    {
        $this->db->insert('inname', $inname);
        return $this->db->insert_id();
    }

    /**
     * Geeft alle innames met hun persoon terug en voedingssupplement gesorteerd op datum uit de tabel inname
     * @author Ruben Tuytens
     * @return Innamespersonen en voedingssupplement terug.
     * @see \Persoon_model::get()
     * @see \Voedingssupplement_model::get()
     */
    function getInnamesPersonen()
    {
        $this->db->order_by('datum', 'asc');
        $query = $this->db->get('inname');

        $innamespersonen = $query->result();

        $this->load->model('persoon_model');
        $this->load->model('voedingssupplement_model');

        foreach ($innamespersonen as $inname) {
            $inname->persoon = $this->persoon_model->get($inname->persoonId);
            $inname->voedingssupplement = $this->voedingssupplement_model->get($inname->voedingssupplementId);

        }

        return $innamespersonen;
    }

    /**
     * Geeft alle innames terug voor de persoon met id = $persoonId
     * @author Ruben Tuytens
     * @return de opgevraagde records
     */
    function getAllByInname($persoonId)
    {
        $this->db->where('persoonId', $persoonId);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('inname');
        return $query->result();
    }


    function getAllFromPersoon($persoonId)
    {
        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('inname');
        return $query->result();
    }

}

?>
