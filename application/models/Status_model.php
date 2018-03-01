<?php
class Status_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('status');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('status');
		return $query->result();
	}

	function update($status)
	{
		$this->db->where('id', $status->id);
		$this->db->update('status_model', $status);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('status_model', $status);
	}

	function insert($status)
	{
		$this->db->insert('status_model', $status);
		return ->db->insert_id();
	}

}

?>
