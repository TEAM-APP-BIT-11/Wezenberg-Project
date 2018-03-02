<?php
class Nieuwsitem_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('nieuwsitem');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('nieuwsitem');
		return $query->result();
	}

	function update($nieuwsitem)
	{
		$this->db->where('id', $nieuwsitem->id);
		$this->db->update('nieuwsitem_model', $nieuwsitem);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('nieuwsitem_model');
	}

	function insert($nieuwsitem)
	{
		$this->db->insert('nieuwsitem_model', $nieuwsitem);
		return $this->db->insert_id();
	}

}

?>
