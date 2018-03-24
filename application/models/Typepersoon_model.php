<?php
/**
* @class Typepersoon_model
* @brief Model-klasse voor typepersoonen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel typepersoon
*/
class Typepersoon_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel typepersoon
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('typepersoon');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel typepersoon
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('typepersoon');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $typepersoon gehaald wordt
	* @param $typepersoon Het record waarmee we een bestaand record willen vervangen
	*/

	function update($typepersoon)
	{
		$this->db->where('id', $typepersoon->id);
		$this->db->update('typepersoon', $typepersoon);
	}

	/*
	* Verwijdert het record in de tabel typepersoon', $typepersoon met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('typepersoon', $typepersoon);
	}

	/*
	* Voegt een nieuw record afstand=$typepersoon', $typepersoon toe in de tabel typepersoon', $typepersoon
	* @param $typepersoon', $typepersoon Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($typepersoon)
	{
		$this->db->insert('typepersoon', $typepersoon);
		return $this->db->insert_id();
	}

}

?>
