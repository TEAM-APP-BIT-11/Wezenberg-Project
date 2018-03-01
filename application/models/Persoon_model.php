<?php
class Persoon_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('persoon');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('persoon');
		return $query->result();
	}

	function update($persoon)
	{
		$this->db->where('id', $persoon->id);
		$this->db->update('persoon_model', $persoon);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('persoon_model', $persoon);
	}

	function insert($persoon)
	{
		$this->db->insert('persoon_model', $persoon);
		return ->db->insert_id();
	}

}

?>
