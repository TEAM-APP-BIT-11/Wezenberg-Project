<?php
/**
* @class Resultaat_model
* @brief Model-klasse voor resultaaten
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel resultaat
*/
class Resultaat_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel resultaat
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('resultaat');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel resultaat
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('resultaat');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $resultaat gehaald wordt
	* @param $resultaat Het record waarmee we een bestaand record willen vervangen
	*/

	function update($resultaat)
	{
		$this->db->where('id', $resultaat->id);
		$this->db->update('resultaat', $resultaat);
	}

	/*
	* Verwijdert het record in de tabel resultaat', $resultaat met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('resultaat', $resultaat);
	}

	/*
	* Voegt een nieuw record afstand=$resultaat', $resultaat toe in de tabel resultaat', $resultaat
	* @param $resultaat', $resultaat Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($resultaat)
	{
		$this->db->insert('resultaat', $resultaat);
		return $this->db->insert_id();
	}

}

?>
