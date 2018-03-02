<?php
class Homepagina_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('homepagina');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('homepagina');
		return $query->result();
	}

	function update($homepagina)
	{
		$this->db->where('id', $homepagina->id);
		$this->db->update('homepagina_model', $homepagina);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('homepagina_model');
	}

	function insert($homepagina)
	{
		$this->db->insert('homepagina_model', $homepagina);
		return $this->db->insert_id();
	}

}

?>
