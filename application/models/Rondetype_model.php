<?php
class Rondetype_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('rondetype');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('rondetype');
		return $query->result();
	}

	function update($rondetype)
	{
		$this->db->where('id', $rondetype->id);
		$this->db->update('rondetype_model', $rondetype);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('rondetype_model', $rondetype);
	}

	function insert($rondetype)
	{
		$this->db->insert('rondetype_model', $rondetype);
		return $this->db->insert_id();
	}

}

?>
