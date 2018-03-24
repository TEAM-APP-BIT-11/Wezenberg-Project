<?php
/**
* @class Slag_model
* @brief Model-klasse voor slagen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel slag
*/
class Slag_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel slag
	* @param $id De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('slag');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel slag
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('slag');
		return $query->result();
	}

	/*
	* Update het record in de tabel slag met de id die uit $slag gehaald wordt
	* @param $slag Het record waarmee we een bestaand record willen vervangen
	*/

	function update($slag)
	{
		$this->db->where('id', $slag->id);
		$this->db->update('slag', $slag);
	}

	/*
	* Verwijdert het record in de tabel slag', $slag met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('slag', $slag);
	}

	/*
	* Voegt een nieuw record slag=$slag', $slag toe in de tabel slag', $slag
	* @param $slag', $slag Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($slag)
	{
		$this->db->insert('slag', $slag);
		return $this->db->insert_id();
	}

}

?>
