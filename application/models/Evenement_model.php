<?php
class Evenement_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evenement');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('evenement');
		return $query->result();
	}

	function update($evenement)
	{
		$this->db->where('id', $evenement->id);
		$this->db->update('evenement_model', $evenement);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('evenement_model', $evenement);
	}

	function insert($evenement)
	{
		$this->db->insert('evenement_model', $evenement);
		return $this->db->insert_id();
	}

}

?>
