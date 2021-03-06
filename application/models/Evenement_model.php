<?php

/**
 * @class Evenement_model
 * @brief Model-klasse voor evenementen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel evenement
 */
class Evenement_model extends CI_Model
{

    /**
     * Constructor
     */

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel evenement
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('evenement');
        return $query->row();
    }

    /**
     * Retourneert het record met id=$id uit de tabel evenement met alle bijhorende deelnames en personen
     * @param $id De id van het record dat opgevraagd wordt
     * @return Het opgevraagde record
     */

    function getWithTypeLocatieDeelnamesAndPersoon($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('evenement');
        $evenement = $query->row();

        $this->load->model('evenementdeelname_model');
        $evenement->deelnames = $this->evenementdeelname_model->getByEventIdWithPerson($id);

        $this->load->model('evenementtype_model');
        $evenement->type = $this->evenementtype_model->get($evenement->evenementTypeId);

        $this->load->model('locatie_model');
        $evenement->locatie = $this->locatie_model->get($evenement->locatieId);

        return $evenement;
    }

    /**
     * Retourneert alle records uit de tabel evenement
     * @return Alle records
     */

    function getAll()
    {
        $query = $this->db->get('evenement');
        return $query->result();
    }

    /**
     * Retourneert alle records uit de tabel evenement, inclusief het evenementtypes
     * @return Alle records met types
     */

    function getAllWithType()
    {
        $query = $this->db->get('evenement');
        $evenementen = $query->result();

        $this->load->model('evenementtype_model');

        foreach ($evenementen as $evenement) {
            $evenement->type = $this->evenementtype_model->get($evenement->evenementTypeId);
        }

        return $evenementen;
    }

    /**
     * Retourneert alle records uit de tabel evenement, inclusief het evenementtypes
     * @return Alle records met types
     */

    function getEvenementenByEvenementReeksId($evenementReeksId)
    {
        $this->db->where('evenementReeksId', $evenementReeksId);
        $query = $this->db->get('evenement');
        return $query->result();
    }

    /**
     * Update het record in de tabel evenement met de id die uit $evenement gehaald wordt
     * @param $evenement Het record waarmee we een bestaand record willen vervangen
     */

    function update($evenement)
    {
        $this->db->where('id', $evenement->id);
        $this->db->update('evenement', $evenement);
    }

    /**
     * Verwijdert het record in de tabel evenement', $evenement met de id=$id
     * @param $id De id van het record dat verwijderd zal worden
     */


    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('evenement');
    }

    /**
     * Voegt een nieuw record evenement=$evenement', $evenement toe in de tabel evenement', $evenement
     * @param $evenement ', $evenement Het nieuwe record dat toegevoegd zal worden
     * @return De id van het nieuw toegevoegde record
     */

    function insert($evenement)
    {
        $this->db->insert('evenement', $evenement);
        return $this->db->insert_id();
    }

}

?>
