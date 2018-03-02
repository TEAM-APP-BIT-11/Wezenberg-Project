<?php
class Wedstrijd_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('wedstrijd');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('wedstrijd');
		return $query->result();
	}

	function update($wedstrijd)
	{
		$this->db->where('id', $wedstrijd->id);
		$this->db->update('wedstrijd_model', $wedstrijd);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('wedstrijd_model');
	}

	function insert($wedstrijd)
	{
		$this->db->insert('wedstrijd_model', $wedstrijd);
		return $this->db->insert_id();
	}

}

?>
