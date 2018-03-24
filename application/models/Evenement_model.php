<?php
/**
* @class Evenement_model
* @brief Model-klasse voor evenementen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel evenement
*/
class Evenement_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel evenement
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evenement');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel evenement
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('evenement');
		return $query->result();
	}

	/*
	* Update het record in de tabel afstand met de id die uit $evenement gehaald wordt
	* @param $evenement Het record waarmee we een bestaand record willen vervangen
	*/

	function update($evenement)
	{
		$this->db->where('id', $evenement->id);
		$this->db->update('evenement', $evenement);
	}

	/*
	* Verwijdert het record in de tabel evenement', $evenement met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('evenement', $evenement);
	}

	/*
	* Voegt een nieuw record afstand=$evenement', $evenement toe in de tabel evenement', $evenement
	* @param $evenement', $evenement Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($evenement)
	{
		$this->db->insert('evenement', $evenement);
		return $this->db->insert_id();
	}
        
        /*
         * 
         */
        
        function getLocatieWithLocatieByDeelnemer($id)
        {
                $this->db->where('id', $id);
                $query = $this->db->get('evenement');

                $product = $query->row();

                $this->load->model('locatie_model');
                $product->soort = $this->soort_model->get($product->soortId);

                $this->load->model('brouwerij_model');
                $product->brouwerij = $this->brouwerij_model->get($product->brouwerijId);

                return $product;
        }
}

?>
