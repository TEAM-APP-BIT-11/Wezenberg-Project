<?php
class Afstand_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('afstand');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('afstand');
		return $query->result();
	}

	function update($afstand)
	{
		$this->db->where('id', $afstand->id);
		$this->db->update('afstand_model', $afstand);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('afstand_model', $afstand);
	}

	function insert($afstand)
	{
		$this->db->insert('afstand_model', $afstand);
		return $this->db->insert_id();
	}

}

?>
