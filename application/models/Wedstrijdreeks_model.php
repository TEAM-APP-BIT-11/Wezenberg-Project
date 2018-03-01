<?php
class Wedstrijdreeks_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('wedstrijdreeks');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('wedstrijdreeks');
		return $query->result();
	}

	function update($wedstrijdreeks)
	{
		$this->db->where('id', $wedstrijdreeks->id);
		$this->db->update('wedstrijdreeks_model', $wedstrijdreeks);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('wedstrijdreeks_model', $wedstrijdreeks);
	}

	function insert($wedstrijdreeks)
	{
		$this->db->insert('wedstrijdreeks_model', $wedstrijdreeks);
		return $this->db->insert_id();
	}

}

?>
