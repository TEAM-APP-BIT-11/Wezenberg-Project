<?php
class Wedstrijddeelname_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('wedstrijddeelname');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('wedstrijddeelname');
		return $query->result();
	}

	function update($wedstrijddeelname)
	{
		$this->db->where('id', $wedstrijddeelname->id);
		$this->db->update('wedstrijddeelname_model', $wedstrijddeelname);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('wedstrijddeelname_model', $wedstrijddeelname);
	}

	function insert($wedstrijddeelname)
	{
		$this->db->insert('wedstrijddeelname_model', $wedstrijddeelname);
		return ->db->insert_id();
	}

}

?>
