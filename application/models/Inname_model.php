<?php
/**
* @class Inname_model
* @brief Model-klasse voor innameen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel inname
*/
class Inname_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel inname
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('inname');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel inname
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('inname');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $inname gehaald wordt
	* @param $inname Het record waarmee we een bestaand record willen vervangen
	*/

	function update($inname)
	{
		$this->db->where('id', $inname->id);
		$this->db->update('inname', $inname);
	}

	/*
	* Verwijdert het record in de tabel inname', $inname met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('inname', $inname);
	}

	/*
	* Voegt een nieuw record afstand=$inname', $inname toe in de tabel inname', $inname
	* @param $inname', $inname Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($inname)
	{
		$this->db->insert('inname', $inname);
		return $this->db->insert_id();
	}

}

?>
