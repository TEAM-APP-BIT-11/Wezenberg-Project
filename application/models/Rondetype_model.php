<?php
/**
* @class Rondetype_model
* @brief Model-klasse voor rondetypeen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel rondetype
*/
class Rondetype_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel rondetype
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('rondetype');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel rondetype
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('rondetype');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $rondetype gehaald wordt
	* @param $rondetype Het record waarmee we een bestaand record willen vervangen
	*/

	function update($rondetype)
	{
		$this->db->where('id', $rondetype->id);
		$this->db->update('rondetype', $rondetype);
	}

	/*
	* Verwijdert het record in de tabel rondetype', $rondetype met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('rondetype', $rondetype);
	}

	/*
	* Voegt een nieuw record afstand=$rondetype', $rondetype toe in de tabel rondetype', $rondetype
	* @param $rondetype', $rondetype Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($rondetype)
	{
		$this->db->insert('rondetype', $rondetype);
		return $this->db->insert_id();
	}

}

?>
