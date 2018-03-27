<?php
/**
* @class Afstand_model
* @brief Model-klasse voor afstanden
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel afstand
*/
class Afstand_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel afstand
	* @param $id De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('afstand');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel afstand
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('afstand');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $afstand gehaald wordt
	* @param $afstand Het record waarmee we een bestaand record willen vervangen
	*/

	function update($afstand)
	{
		$this->db->where('id', $afstand->id);
		$this->db->update('afstand', $afstand);
	}

	/*
	* Verwijdert het record in de tabel afstand', $afstand met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('afstand', $afstand);
	}

	/*
	* Voegt een nieuw record afstand=$afstand', $afstand toe in de tabel afstand', $afstand
	* @param $afstand', $afstand Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($afstand)
	{
		$this->db->insert('afstand', $afstand);
		return $this->db->insert_id();
	}

}

?>
