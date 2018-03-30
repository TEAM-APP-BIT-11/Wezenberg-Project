<?php

/**
 * @class Persoon_model
 * @brief Model-klasse voor persoonen
 *
 * Model-klasse die alle methodes bevat om te
 * interageren met de database-tabel persoon
 */
class Persoon_model extends CI_Model
{
    /*
    * Constructor
    */

    function __construct()
    {
        parent::__construct();
    }

    /*
    * Retourneert het record met id=$id uit de tabel persoon
    * @param $id De id van het record dat opgevraagd wordt
    * @return Het opgevraagde record
    */

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    /*
     * Retourneert de persoon uit de tabel persoon die bij de opgegeven gebruikersnaam=$gebruikersnaam en wachtwoord=$wachtwoord hoort
     * @param $gebruikersnaam De gebruikersnaam waarmee de persoon wilt inloggen
     * @param $wachtwoord Het wachtwoord dat bij de gebruikersnaam zou moeten horen
     * @return Het opgevraagde record uit de tabel persoon, of null als de gegevens niet kloppen
     */

    function getPersoonWithType($gebruikersnaam, $wachtwoord)
    {
        echo $gebruikersnaam . " - 0" . $wachtwoord;
        $this->db->where('gebruikersnaam', $gebruikersnaam);

        $this->db->where('actief', 1);
        $query = $this->db->get('persoon');
        echo "rij : " . $query->num_rows();

        if ($query->num_rows() == 1) {
            $gebruiker = $query->row();
            // controleren of het wachtwoord overeenkomt
            if (password_verify($wachtwoord, $gebruiker->wachtwoord)) {
                echo "wachtwoord ok";
                $this->load->model('typepersoon_model');
                $gebruiker->typePersoon = $this->typepersoon_model->get($gebruiker->typePersoonId);
                return $gebruiker;
            } else {
                echo "wachtwoord fout";
                return null;
            }
        } else {
            echo "geen gebruiker";
            return null;
        }
    }


    /*
    * Retourneert alle records uit de tabel persoon
    * @return Alle records
    */

    function getAll()
    {
        $query = $this->db->get('persoon');
        return $query->result();
    }
    
    /*
    * Retourneert alle records uit de tabel persoon die een zwemmer zijn
    * @return Alle records
    */

    function getZwemmers()
    {
        $query = $this->db->get('persoon');
        return $query->result();
    }

    /*
    * Update het record in de tabel persoon met de id die uit $persoon gehaald wordt
    * @param $persoon Het record waarmee we een bestaand record willen vervangen
    */

    function update($persoon)
    {
        $this->db->where('id', $persoon->id);
        $this->db->update('persoon', $persoon);
    }

    /*
    * Verwijdert het record in de tabel persoon', $persoon met de id=$id
    * @param $id De id van het record dat verwijderd zal worden
    */


    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('persoon');
        $this->db - delete('persoon', $persoon);
    }

    /*
    * Voegt een nieuw record persoon=$persoon', $persoon toe in de tabel persoon', $persoon
    * @param $persoon', $persoon Het nieuwe record dat toegevoegd zal worden
    * @return De id van het nieuw toegevoegde record
    */

    function insert($persoon)
    {
        $this->db->insert('persoon', $persoon);
        return $this->db->insert_id();
    }
}

?>
