<?php
class Evenementdeelname_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evenementdeelname');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('evenementdeelname');
		return $query->result();
	}

	function update($evenementdeelname)
	{
		$this->db->where('id', $evenementdeelname->id);
		$this->db->update('evenementdeelname_model', $evenementdeelname);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('evenementdeelname_model');
	}

	function insert($evenementdeelname)
	{
		$this->db->insert('evenementdeelname_model', $evenementdeelname);
		return $this->db->insert_id();
	}

        function getAllJoinLeverancier()
        {
            $this->db->select('*, shop_product.id as productId');
            $this->db->from('shop_product');
            $this->db->join('shop_leverancier', 
                    'shop_leverancier.id = shop_product.leverancierId');
            $this->db->order_by('nederlandseNaam', 'asc');
            $query = $this->db->get();
            return $query->result();
        }
    
}

?>
