<?php
class Evenementreeks_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evenementreeks');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('evenementreeks');
		return $query->result();
	}

	function update($evenementreeks)
	{
		$this->db->where('id', $evenementreeks->id);
		$this->db->update('evenementreeks_model', $evenementreeks);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('evenementreeks_model', $evenementreeks);
	}

	function insert($evenementreeks)
	{
		$this->db->insert('evenementreeks_model', $evenementreeks);
		return ->db->insert_id();
	}

}

?>
