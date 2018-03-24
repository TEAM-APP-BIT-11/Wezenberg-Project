<?php
/**
* @class Evenementdeelname_model
* @brief Model-klasse voor evenementdeelnameen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel evenementdeelname
*/
class Evenementdeelname_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel evenementdeelname
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evenementdeelname');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel evenementdeelname
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('evenementdeelname');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $evenementdeelname gehaald wordt
	* @param $evenementdeelname Het record waarmee we een bestaand record willen vervangen
	*/

	function update($evenementdeelname)
	{
		$this->db->where('id', $evenementdeelname->id);
		$this->db->update('evenementdeelname', $evenementdeelname);
	}

	/*
	* Verwijdert het record in de tabel evenementdeelname', $evenementdeelname met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('evenementdeelname', $evenementdeelname);
	}

	/*
	* Voegt een nieuw record afstand=$evenementdeelname', $evenementdeelname toe in de tabel evenementdeelname', $evenementdeelname
	* @param $evenementdeelname', $evenementdeelname Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($evenementdeelname)
	{
		$this->db->insert('evenementdeelname', $evenementdeelname);
		return $this->db->insert_id();
	}

}

?>
