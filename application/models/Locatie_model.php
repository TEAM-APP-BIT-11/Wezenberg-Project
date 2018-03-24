<?php
class Locatie_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('locatie');
        return $query->row();
    }

    public function getAll()
    {
        $query = $this->db->get('locatie');
        return $query->result();
    }

    public function update($locatie)
    {
        $this->db->where('id', $locatie->id);
        $this->db->update('locatie_model', $locatie);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('locatie')) {
            $error = $this->db->error();
            $msg = "Locatie heeft evenement!";
						return $msg;
        } else {
            $msg = "Locatie verwijderd!";
						return $msg;
        }
    }

    public function insert($locatie)
    {
        $this->db->insert('locatie_model', $locatie);
        return $this->db->insert_id();
    }
}
