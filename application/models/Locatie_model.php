<?php
/**
* @class Locatie_model
* @brief Model-klasse voor locatieen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel locatie
*/
class Locatie_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel locatie
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('locatie');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel locatie
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('locatie');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $locatie gehaald wordt
	* @param $locatie Het record waarmee we een bestaand record willen vervangen
	*/

	function update($locatie)
	{
		$this->db->where('id', $locatie->id);
		$this->db->update('locatie', $locatie);
	}

	/*
	* Verwijdert het record in de tabel locatie', $locatie met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('locatie', $locatie);
	}

	/*
	* Voegt een nieuw record afstand=$locatie', $locatie toe in de tabel locatie', $locatie
	* @param $locatie', $locatie Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($locatie)
	{
		$this->db->insert('locatie', $locatie);
		return $this->db->insert_id();
	}
}
