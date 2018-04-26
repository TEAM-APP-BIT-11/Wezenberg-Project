<?php
/**
 * Created by PhpStorm.
 * User: Neil
 * Date: 20/04/2018
 * Time: 14:46
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Melding
{
    public function __construct()
    {
    }

    /**
     * Voegt meldingen aan de database toe.
     * @author Neil Van den Broeck
     * @see \Melding_model::insert()
     * @param $ids een string met de toe te voegen ids gescheiden door een komma of een lijst met personen waarnaar de melding moet worden gestuurd. Deze worden correct in de functie geformateerd.
     * @param $boodschap Boodschap van de melding.
     * @param $titel titel van de melding die gegenereerd moet worden.
     */
    public function genereerMeldingen($ids, $boodschap, $titel)
    {
        $persoonIds = array();

        $CI = &get_instance();
        if (is_string($ids)) {
            $persoonIds = array_filter(explode(',', $ids));
        } else {
            foreach ($ids as $id) {
                array_push($persoonIds, $id->id);
            }
        }

        $CI->load->model('melding_model');
        foreach ($persoonIds as $id) {
            $melding = new stdClass();
            $melding->persoonId = $id;
            $melding->titel = $titel;
            $melding->boodschap = $boodschap;
            $melding->momentVerzonden = date("Y-m-d H:i:s");
            $melding->gelezen = 0;
            $CI->melding_model->insert($melding);
        }
    }

    /**
     * Melding genereren voor een specifieke persoon.
     * Melding wordt toegevoegd in de database.
     * @author Neil Van den Broeck
     * @see \Melding_model::insert()
     * @param $persoonId id van de persoon waarvoor de melding moet gegenereerd worden.
     * @param $boodschap boodschap van de melding die gegenereerd wordt.
     * @param $titel de titel van de melding die gegenereerd wordt.
     */

    public function genereerMelding($persoonId, $boodschap, $titel)
    {
        $CI = &get_instance();
        $melding = new stdClass();
        $melding->persoonId = $persoonId;
        $melding->titel = $titel;
        $melding->boodschap = $boodschap;
        $melding->momentVerzonden = date("Y-m-d H:i:s");
        $melding->gelezen = 0;
        $CI->melding_model->insert($melding);
    }
}