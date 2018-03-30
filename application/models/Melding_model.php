<?php

/**
 * @class Melding_model
 * @brief Model-klasse voor meldingen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel melding
 */
class Melding_model extends CI_Model
{
    /*
    * Constructor
    */

    function __construct()
    {
        parent::__construct();
    }

    /*
    * Retourneert het record met id=$id uit de tabel melding
    * @param $id De id van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('melding');
        return $query->row();
    }

    /*
    * Retourneert alle records uit de tabel melding
    * @return Alle records
    */

    function getAll()
    {
        $query = $this->db->get('melding');
        return $query->result();
    }

    /*
         * Retourneert alle meldingen voor de persoon met id=$persoonId
         * @param De id van de persoon waarvoor de meldingen opgevraagd worden
         * @return De opgevraagde records
         */

    function getAllFromPersoonAndNietGelezen($persoonId)
    {
        $this->db->where('gelezen', 0);
        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('melding');
        return $query->result();
    }

    /*
* Update het record in de tabel melding met de id die uit $melding gehaald wordt
* @param $melding Het record waarmee we een bestaand record willen vervangen
*/

    function update($melding)
    {
        $this->db->where('id', $melding->id);
        $this->db->update('melding', $melding);
    }

    /*
    * Verwijdert het record in de tabel melding', $melding met de id=$id
    * @param $id De id van het record dat verwijderd zal worden
    */


    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db - delete('melding', $melding);
    }

    /*
    * Voegt een nieuw record melding=$melding', $melding toe in de tabel melding', $melding
    * @param $melding', $melding Het nieuwe record dat toegevoegd zal worden
    * @return De id van het nieuw toegevoegde record
    */

    function insert($melding)
    {
        $this->db->insert('melding', $melding);
        return $this->db->insert_id();
    }

}

?>
