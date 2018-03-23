<?php

class Persoon_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    function getPersoon($gebruikersnaam, $wachtwoord)
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

    function getAll()
    {
        $query = $this->db->get('persoon');
        return $query->result();
    }

    function update($persoon)
    {
        $this->db->where('id', $persoon->id);
        $this->db->update('persoon_model', $persoon);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('persoon_model');
    }

    function insert($persoon)
    {
        $this->db->insert('persoon_model', $persoon);
        return $this->db->insert_id();
    }

}

?>
