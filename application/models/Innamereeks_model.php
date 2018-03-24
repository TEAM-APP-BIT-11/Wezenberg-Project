<?php
/**
* @class Innamereeks_model
* @brief Model-klasse voor innamereeksen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel innamereeks
*/
class Innamereeks_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel innamereeks
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('innamereeks');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel innamereeks
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('innamereeks');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $innamereeks gehaald wordt
	* @param $innamereeks Het record waarmee we een bestaand record willen vervangen
	*/

	function update($innamereeks)
	{
		$this->db->where('id', $innamereeks->id);
		$this->db->update('innamereeks', $innamereeks);
	}

	/*
	* Verwijdert het record in de tabel innamereeks', $innamereeks met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('innamereeks', $innamereeks);
	}

	/*
	* Voegt een nieuw record afstand=$innamereeks', $innamereeks toe in de tabel innamereeks', $innamereeks
	* @param $innamereeks', $innamereeks Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($innamereeks)
	{
		$this->db->insert('innamereeks', $innamereeks);
		return $this->db->insert_id();
	}

}

?>
