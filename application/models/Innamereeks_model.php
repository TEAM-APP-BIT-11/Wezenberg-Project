<?php
class Innamereeks_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('innamereeks');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('innamereeks');
		return $query->result();
	}

	function update($innamereeks)
	{
		$this->db->where('id', $innamereeks->id);
		$this->db->update('innamereeks_model', $innamereeks);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('innamereeks_model');
	}

	function insert($innamereeks)
	{
		$this->db->insert('innamereeks_model', $innamereeks);
		return $this->db->insert_id();
	}

}

?>
