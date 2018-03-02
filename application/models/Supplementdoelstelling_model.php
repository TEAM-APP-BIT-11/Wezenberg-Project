<?php
class Supplementdoelstelling_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('supplementdoelstelling');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('supplementdoelstelling');
		return $query->result();
	}

	function update($supplementdoelstelling)
	{
		$this->db->where('id', $supplementdoelstelling->id);
		$this->db->update('supplementdoelstelling_model', $supplementdoelstelling);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('supplementdoelstelling_model');
	}

	function insert($supplementdoelstelling)
	{
		$this->db->insert('supplementdoelstelling_model', $supplementdoelstelling);
		return $this->db->insert_id();
	}

}

?>
