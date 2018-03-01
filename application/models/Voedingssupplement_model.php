<?php
class Voedingssupplement_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('voedingssupplement');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('voedingssupplement');
		return $query->result();
	}

	function update($voedingssupplement)
	{
		$this->db->where('id', $voedingssupplement->id);
		$this->db->update('voedingssupplement_model', $voedingssupplement);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('voedingssupplement_model', $voedingssupplement);
	}

	function insert($voedingssupplement)
	{
		$this->db->insert('voedingssupplement_model', $voedingssupplement);
		return $this->db->insert_id();
	}

}

?>
