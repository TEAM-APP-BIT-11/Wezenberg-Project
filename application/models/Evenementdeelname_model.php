<?php
class Evenementdeelname_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evenementdeelname');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('evenementdeelname');
		return $query->result();
	}

	function update($evenementdeelname)
	{
		$this->db->where('id', $evenementdeelname->id);
		$this->db->update('evenementdeelname_model', $evenementdeelname);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('evenementdeelname_model', $evenementdeelname);
	}

	function insert($evenementdeelname)
	{
		$this->db->insert('evenementdeelname_model', $evenementdeelname);
		return $this->db->insert_id();
	}

}

?>
