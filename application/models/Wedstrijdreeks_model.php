<?php
/**
* @class Wedstrijdreeks_model
* @brief Model-klasse voor wedstrijdreeksen
* 
* Model-klasse die alle methodes bevat om te
* interageren met de database-tabel wedstrijdreeks
*/
class Wedstrijdreeks_model extends CI_Model {
	/*
	* Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/*
	* Retourneert het record met id=$id uit de tabel wedstrijdreeks
	* @param  De id van het record dat opgevraagd wordt
	* @return Het opgevraagde record
	*/

	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('wedstrijdreeks');
		return $query->row();
	}

	/*
	* Retourneert alle records uit de tabel wedstrijdreeks
	* @return Alle records
	*/

	function getAll()
	{
		$query = $this->db->get('wedstrijdreeks');
		return $query->result();
	}
        
        /*
         * Retourneert alle records uit de tabel wedstrijdreeks met bijhorende wedstrijd, slag en afstand
         * @return Alle records inclusief bijhorende wedstrijd, slag en afstand
         */
        
        function getAllWithWedstrijdSlagAfstand()
        {
                $query = $this->db->get('wedstrijdreeks');
                $wedstrijdreeksen = $query->result();

                $this->load->model('slag_model');
                $this->load->model('afstand_model');
                $this->load->model('wedstrijd_model');

                foreach($wedstrijdreeksen as $wedstrijdreeks) {
                        $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
                        $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
                        $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
                }
                return $wedstrijdreeksen;
	}

        /*
         * Retourneert de records uit de tabel wedstrijdreeks met bijhorende slag en afstand voor de persoon met id=$persoonId die deelneemt aan de wedstrijd met id=$wedstrijdId
         * @param $persoonId De id van de persoon waarvoor records opgehaald worden
         * @param $wedstrijdId De id van de wedstrijd waaraan de persoon waarvoor records opgehaald worden deelneemt
         * @return De gevraagde records
         */
        
	function getAllWithWedstrijdSlagAfstandAndDeelnamePersoon($persoonId, $wedstrijdId){
		$this->db->where('wedstrijdId', $wedstrijdId);
                $query = $this->db->get('wedstrijdreeks');
                $wedstrijdreeksen = $query->result();

                $this->load->model('slag_model');
                $this->load->model('afstand_model');
                $this->load->model('wedstrijd_model');
                $this->load->model('wedstrijddeelname_model');

                $deelnames = $this->wedstrijddeelname_model->getAllForPersoonWithStatus($persoonId);

                foreach($wedstrijdreeksen as $wedstrijdreeks) {
                        $wedstrijdreeks->slag = $this->slag_model->get($wedstrijdreeks->slagId);
                        $wedstrijdreeks->afstand = $this->afstand_model->get($wedstrijdreeks->afstandId);
                        $wedstrijdreeks->wedstrijd = $this->wedstrijd_model->get($wedstrijdreeks->wedstrijdId);
                        foreach($deelnames as $deelname){
                                if($wedstrijdreeks->id == $deelname->wedstrijdReeksId){
                                            $wedstrijdreeks->deelname = $deelname;
                                }
                        }
                }
		return $wedstrijdreeksen;
	}

	/*
	* Update het record in de tabel afstand met de id die uit $wedstrijdreeks gehaald wordt
	* @param $wedstrijdreeks Het record waarmee we een bestaand record willen vervangen
	*/

	function update($wedstrijdreeks)
	{
		$this->db->where('id', $wedstrijdreeks->id);
		$this->db->update('wedstrijdreeks', $wedstrijdreeks);
	}

	/*
	* Verwijdert het record in de tabel wedstrijdreeks', $wedstrijdreeks met de id=$id
	* @param $id De id van het record dat verwijderd zal worden
	*/


	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db-delete('wedstrijdreeks', $wedstrijdreeks);
	}

	/*
	* Voegt een nieuw record afstand=$wedstrijdreeks', $wedstrijdreeks toe in de tabel wedstrijdreeks', $wedstrijdreeks
	* @param $wedstrijdreeks', $wedstrijdreeks Het nieuwe record dat toegevoegd zal worden
	* @return De id van het nieuw toegevoegde record
	*/

	function insert($wedstrijdreeks)
	{
		$this->db->insert('wedstrijdreeks', $wedstrijdreeks);
		return $this->db->insert_id();
	}

}

?>
