<?php

/**
 * @class Evenementdeelname_model
 * @brief Model-klasse voor evenementdeelnameen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel evenementdeelname
 */
class Evenementdeelname_model extends CI_Model
{
    /**
     * Constructor
     */

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel evenementdeelname
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('evenementdeelname');
        return $query->row();
    }

    /**
     * Retourneert de records met evenementId=$evenementId uit de tabel evenementdeelname
     * @param $evenementId De id van het record dat opgevraagd wordt
     * @return De opgevraagde records
     */

    function getByEventId($evenementId)
    {
        $this->db->where('evenementId', $evenementId);
        $query = $this->db->get('evenementdeelname');
        $evenementdeelnames = $query->result();

        return $evenementdeelnames;
    }

    /**
     * Retourneert de records met evenementId=$evenementId uit de tabel evenementdeelname inclusief bijhorende persoon
     * @param $evenementId De id van het record dat opgevraagd wordt
     * @return De opgevraagde records
     */

    function getByEventIdWithPerson($evenementId)
    {
        $this->db->where('evenementId', $evenementId);
        $query = $this->db->get('evenementdeelname');
        $evenementdeelnames = $query->result();

        $this->load->model('persoon_model');

        foreach ($evenementdeelnames as $evenementdeelname) {
            $evenementdeelname->persoon = $this->persoon_model->get($evenementdeelname->persoonId);
        }

        return $evenementdeelnames;
    }

    /**
     * Retourneert alle records uit de tabel evenementdeelname
     * @return Alle records
     */

    function getAll()
    {
        $query = $this->db->get('evenementdeelname');
        return $query->result();
    }

    /**
     * Update het record in de tabel evenementdeelname met de id die uit $evenementdeelname gehaald wordt
     * @param $evenementdeelname Het record waarmee we een bestaand record willen vervangen
     */

    function update($evenementdeelname)
    {
        $this->db->where('id', $evenementdeelname->id);
        $this->db->update('evenementdeelname', $evenementdeelname);
    }

    /**
     * Verwijdert het record in de tabel evenementdeelname', $evenementdeelname met de id=$id
     * @param $id De id van het record dat verwijderd zal worden
     */


    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('evenementdeelname');
    }

    /**
     * Voegt een nieuw record evementdeelname=$evenementdeelname', $evenementdeelname toe in de tabel evenementdeelname', $evenementdeelname
     * @param $evenementdeelname ', $evenementdeelname Het nieuwe record dat toegevoegd zal worden
     * @return De id van het nieuw toegevoegde record
     */

    function insert($evenementdeelname)
    {
        $this->db->insert('evenementdeelname', $evenementdeelname);
        return $this->db->insert_id();
    }

    /**
     * Geeft alle evenementdeelnames uit de tabel evenementdeelname waar persoonId = $persoonId
     * Bijgevoegd ook de locatie en het evenement
     * @param $persoonId
     * @return alle gevraagde records
     * @author Neil Van den Broeck
     */

    function getAllFromPersoonWithEvenement($persoonId)
    {
        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('evenementdeelname');
        $evenementdeelnames = $query->result();

        $this->load->model('evenement_model');
        $this->load->model('locatie_model');

        foreach ($evenementdeelnames as $evenementdeelname) {
            $evenementdeelname->evenement = $this->evenement_model->get($evenementdeelname->evenementId);
            $evenementdeelname->evenement->locatie = $this->locatie_model->get($evenementdeelname->evenement->locatieId);
        }

        return $evenementdeelnames;
    }
}

?>
