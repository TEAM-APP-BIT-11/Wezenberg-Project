<?php
class Evenementtype_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evenementtype');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('evenementtype');
		return $query->result();
	}

	function update($evenementtype)
	{
		$this->db->where('id', $evenementtype->id);
		$this->db->update('evenementtype_model', $evenementtype);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('evenementtype_model', $evenementtype);
	}

	function insert($evenementtype)
	{
		$this->db->insert('evenementtype_model', $evenementtype);
		return ->db->insert_id();
	}

}

?>
