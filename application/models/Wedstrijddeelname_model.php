<?php
/**
* @class Wedstrijddeelname_model
* @brief Model-klasse voor wedstrijddeelnameen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel wedstrijddeelname
*/
class Wedstrijddeelname_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel wedstrijddeelname
	* @param $id De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('wedstrijddeelname');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel wedstrijddeelname
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('wedstrijddeelname');
		return $query->result();
	}
        
        /*
         * Retourneert alle wedstrijddeelnames uit de tabel wedstrijddeelname voor de persoon met id=$persoonID, inclusief de bijhorende status
         * @param $persoonId De id van de persoon waarvoor de wedstrijddeelnames opgehaald worden
         * @return De opgevraagde wedstrijddeelnames met status
         */

	function getAllForPersoon($persoonId)
        {
		$this->db->where('persoonId', $persoonId);
                $query = $this->db->get('wedstrijddeelname');
                $wedstrijddeelnames = $query->result();

                $this->load->model('status_model');

                foreach($wedstrijddeelnames as $wedstrijddeelname){
                        $wedstrijddeelname->status = $this->status_model->get($wedstrijddeelname->statusId);
                }

                return $wedstrijddeelnames;
	}

	/*
	* Update het record in de tabel wedstrijddeelname met de id die uit $wedstrijddeelname gehaald wordt
	* @param $wedstrijddeelname Het record waarmee we een bestaand record willen vervangen
	*/

	function update($wedstrijddeelname)
	{
		$this->db->where('id', $wedstrijddeelname->id);
		$this->db->update('wedstrijddeelname', $wedstrijddeelname);
	}

	/*
	* Verwijdert het record in de tabel wedstrijddeelname', $wedstrijddeelname met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('wedstrijddeelname', $wedstrijddeelname);
	}

	/*
	* Voegt een nieuw record wedstrijddeelname=$wedstrijddeelname', $wedstrijddeelname toe in de tabel wedstrijddeelname', $wedstrijddeelname
	* @param $wedstrijddeelname', $wedstrijddeelname Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($wedstrijddeelname)
	{
		$this->db->insert('wedstrijddeelname', $wedstrijddeelname);
		return $this->db->insert_id();
	}

}

?>
