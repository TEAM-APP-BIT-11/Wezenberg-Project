<?php
class Slag_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('slag');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('slag');
		return $query->result();
	}

	function update($slag)
	{
		$this->db->where('id', $slag->id);
		$this->db->update('slag_model', $slag);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('slag_model');
	}

	function insert($slag)
	{
		$this->db->insert('slag_model', $slag);
		return $this->db->insert_id();
	}

}

?>
