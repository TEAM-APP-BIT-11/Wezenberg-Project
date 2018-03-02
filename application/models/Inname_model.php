<?php
class Inname_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('inname');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('inname');
		return $query->result();
	}

	function update($inname)
	{
		$this->db->where('id', $inname->id);
		$this->db->update('inname_model', $inname);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('inname_model');
	}

	function insert($inname)
	{
		$this->db->insert('inname_model', $inname);
		return $this->db->insert_id();
	}

}

?>
