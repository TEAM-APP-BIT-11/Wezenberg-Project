<?php
class Typepersoon_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('typepersoon');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('typepersoon');
		return $query->result();
	}

	function update($typepersoon)
	{
		$this->db->where('id', $typepersoon->id);
		$this->db->update('typepersoon_model', $typepersoon);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('typepersoon_model', $typepersoon);
	}

	function insert($typepersoon)
	{
		$this->db->insert('typepersoon_model', $typepersoon);
		return ->db->insert_id();
	}

}

?>
