<?php
class WedstrijdReeks_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('wedstrijdreeks');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('wedstrijdreeks');
		return $query->result();
	}

	function getAllWithWedstrijdSlagAfstand(){
        $query = $this->db->get('wedstrijdreeks');
        $wedstrijdreeksen = $query->result();

     	$this->load->model('slag_model');
     	$this->load->model('afstand_model');
     	$this->load->model('wedstrijd_model');

		foreach($wedstrijdreeksen as $wedstrijdreeks) {
            $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
            $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
            $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
        }
		return $wedstrijdreeksen;
	}

	function update($wedstrijdreeks)
	{
		$this->db->where('id', $wedstrijdreeks->id);
		$this->db->update('WedstrijdReeks_model', $wedstrijdreeks);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('WedstrijdReeks_model');
	}

	function insert($wedstrijdreeks)
	{
		$this->db->insert('WedstrijdReeks_model', $wedstrijdreeks);
		return $this->db->insert_id();
	}

}

?>
