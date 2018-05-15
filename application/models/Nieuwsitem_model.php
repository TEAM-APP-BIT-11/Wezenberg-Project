<?php
/**
* @class Nieuwsitem_model
* @brief Model-klasse voor nieuwsitemen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel nieuwsitem
*/
class Nieuwsitem_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel nieuwsitem
	* @param $id De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('nieuwsitem');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel nieuwsitem
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('nieuwsitem');
		return $query->result();
	}

	/*
	* Update het record in de tabel nieuwsitem met de id die uit $nieuwsitem gehaald wordt
	* @param $nieuwsitem Het record waarmee we een bestaand record willen vervangen
	*/

	function update($nieuwsitem)
	{
		$this->db->where('id', $nieuwsitem->id);
		$this->db->update('nieuwsitem', $nieuwsitem);
	}

	/*
	* Verwijdert het record in de tabel nieuwsitem', $nieuwsitem met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('nieuwsitem', $nieuwsitem);
	}

	/*
	* Voegt een nieuw record nieuwsitem=$nieuwsitem', $nieuwsitem toe in de tabel nieuwsitem', $nieuwsitem
	* @param $nieuwsitem', $nieuwsitem Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($nieuwsitem)
	{
		$this->db->insert('nieuwsitem', $nieuwsitem);
		return $this->db->insert_id();
	}
        /**
     * Geeft alle nieuwsitems terug waar actief = 1
     * @author Ruben Tuytens
     * @return de opgevraagde records die actief zijn
     */
	 function getNieuws()
	{
		$this->db->where('actief', 1);
		$query = $this->db->get('nieuwsitem');
		$nieuws = $query->result();
                
                return $nieuws ;
	}	
}

?>
