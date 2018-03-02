<?php
class Resultaat_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('resultaat');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('resultaat');
		return $query->result();
	}

	function update($resultaat)
	{
		$this->db->where('id', $resultaat->id);
		$this->db->update('resultaat_model', $resultaat);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('resultaat_model');
	}

	function insert($resultaat)
	{
		$this->db->insert('resultaat_model', $resultaat);
		return $this->db->insert_id();
	}

}

?>
