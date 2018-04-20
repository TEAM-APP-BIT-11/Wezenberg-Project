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

    public function genereerMeldingen($ids, $boodschap, $titel)
    {
        $persoonIds = [];

        $CI = &get_instance();
        if (is_string($ids)) {
            $persoonIds = array_filter(explode(',', $ids));
        } else {
            foreach ($ids as $id) {
                array_push($persoonIds, $id->id);
                var_dump($id);
            }
        }

        var_dump($persoonIds);
        $CI->load->model('melding_model');
        foreach ($persoonIds as $id) {
            var_dump($id);
            $melding = new stdClass();
            $melding->persoonId = $id;
            $melding->titel = $titel;
            $melding->boodschap = $boodschap;
            $melding->momentVerzonden = date("Y-m-d H:i:s");
            $melding->gelezen = 0;
            $CI->melding_model->insert($melding);
        }
    }

    public function genereerMelding($id, $boodschap, $titel)
    {
        $CI = &get_instance();
        $melding = new stdClass();
        $melding->persoonId = $id;
        $melding->titel = $titel;
        $melding->boodschap = $boodschap;
        $melding->momentVerzonden = date("Y-m-d H:i:s");
        $melding->gelezen = 0;
        $CI->melding_model->insert($melding);
    }
}