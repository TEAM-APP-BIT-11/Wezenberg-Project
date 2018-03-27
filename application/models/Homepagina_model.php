<?php
/**
* @class Homepagina_model
* @brief Model-klasse voor homepaginaen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel homepagina
*/
class Homepagina_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel homepagina
	* @param $id De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('homepagina');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel homepagina
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('homepagina');
		return $query->result();
	}

	/*
	* Update het record in de tabel homepagina met de id die uit $homepagina gehaald wordt
	* @param $homepagina Het record waarmee we een bestaand record willen vervangen
	*/

	function update($homepagina)
	{
		$this->db->where('id', $homepagina->id);
		$this->db->update('homepagina', $homepagina);
	}

	/*
	* Verwijdert het record in de tabel homepagina', $homepagina met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('homepagina', $homepagina);
	}

	/*
	* Voegt een nieuw record homepagina=$homepagina', $homepagina toe in de tabel homepagina', $homepagina
	* @param $homepagina', $homepagina Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($homepagina)
	{
		$this->db->insert('homepagina', $homepagina);
		return $this->db->insert_id();
	}

}

?>
