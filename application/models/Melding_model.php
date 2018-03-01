<?php
class Melding_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('melding');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('melding');
		return $query->result();
	}

	function update($melding)
	{
		$this->db->where('id', $melding->id);
		$this->db->update('melding_model', $melding);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('melding_model', $melding);
	}

	function insert($melding)
	{
		$this->db->insert('melding_model', $melding);
		return $this->db->insert_id();
	}

}

?>
