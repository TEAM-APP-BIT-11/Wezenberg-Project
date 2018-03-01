<?php
class Locatie_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('locatie');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('locatie');
		return $query->result();
	}

	function update($locatie)
	{
		$this->db->where('id', $locatie->id);
		$this->db->update('locatie_model', $locatie);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('locatie_model', $locatie);
	}

	function insert($locatie)
	{
		$this->db->insert('locatie_model', $locatie);
		return ->db->insert_id();
	}

}

?>
