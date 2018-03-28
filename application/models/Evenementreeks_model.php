<?php
/**
* @class Evenementreeks_model
* @brief Model-klasse voor evenementreeksen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel evenementreeks
*/
class Evenementreeks_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel evenementreeks
	* @param $id De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evenementreeks');
		return $query->row();
	}
        
        /*
	* Retourneert het record met naam=$evenementReeksNaam uit de tabel evenementreeks
	* @param $evenementReeksNaam De naam van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function getByNaam($evenementReeksNaam)
	{
		$this->db->where('naam', $evenementReeksNaam);
		$query = $this->db->get('evenementreeks');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel evenementreeks
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('evenementreeks');
		return $query->result();
	}

	/*
	* Update het record in de tabel evenementreeks met de id die uit $evenementreeks gehaald wordt
	* @param $evenementreeks Het record waarmee we een bestaand record willen vervangen
	*/

	function update($evenementreeks)
	{
		$this->db->where('id', $evenementreeks->id);
		$this->db->update('evenementreeks', $evenementreeks);
	}

	/*
	* Verwijdert het record in de tabel evenementreeks', $evenementreeks met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('evenementreeks', $evenementreeks);
	}

	/*
	* Voegt een nieuw record evenementreeks=$evenementreeks', $evenementreeks toe in de tabel evenementreeks', $evenementreeks
	* @param $evenementreeks', $evenementreeks Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($evenementreeks)
	{
		$this->db->insert('evenementreeks', $evenementreeks);
		return $this->db->insert_id();
	}

}

?>
