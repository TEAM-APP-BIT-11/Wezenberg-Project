<?php
class WedstrijdDeelname_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('wedstrijddeelname');
		return $query->row();
	}

	function getAll()
	{
		$query = $this->db->get('wedstrijddeelname');
		return $query->result();
	}

    function getAllForPersoon($persoonId){
        $this->db->where('persoonId', $persoonId);
        $query = $this->db->get('wedstrijddeelname');
        $wedstrijddeelnames = $query->result();

        $this->load->model('status_model');

        foreach($wedstrijddeelnames as $wedstrijddeelname){
            $wedstrijddeelname->status = $this->status_model->get($wedstrijddeelname->statusId);
        }

        return $wedstrijddeelnames;
    }


	function getAllForPersoonWithStatus($persoonId){
		$this->db->where('persoonId', $persoonId);
        $query = $this->db->get('wedstrijddeelname');
        $wedstrijddeelnames = $query->result();

        $this->load->model('status_model');

		foreach($wedstrijddeelnames as $wedstrijddeelname){
			$wedstrijddeelname->status = $this->status_model->get($wedstrijddeelname->statusId);
		}

		return $wedstrijddeelnames;
	}

	function update($wedstrijddeelname)
	{
		$this->db->where('id', $wedstrijddeelname->id);
		$this->db->update('WedstrijdDeelname_model', $wedstrijddeelname);
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('wedstrijdDeelname');
	}

	function insert($wedstrijddeelname)
	{
		$this->db->insert('WedstrijdDeelname', $wedstrijddeelname);
		return $this->db->insert_id();
	}

}

?>
