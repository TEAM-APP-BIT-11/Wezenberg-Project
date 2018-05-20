<?php
/**
 * @file wedstrijdresultaat_aanpassen.php
 * @author Dieter Verboven
 * View waarin de gebruiker de gegevens van een resultaat kan aanpassen.
 * - toont een $resultaat-object in een formulier.
 */
?>

<div class="col-md-10 content">

    <h1 class="">Wedstrijdresultaat aanpassen</h1>
    <hr>

    <?php
    foreach ($rondetypes as $rondetype) {
        $rondetypeOpties[$rondetype->id] = $rondetype->type;
    }
    
    foreach ($zwemmers as $zwemmer) {
        $zwemmerOpties[$zwemmer->persoon->id] = $zwemmer->persoon->voornaam;
    }
    $attributes = array('name' => 'wedstrijdResultaatAanpassenFormulier', 'data-toggle' => 'validator', 'role' => 'form');
    echo form_open('trainer/Wedstrijdresultaat/pasAan', $attributes);
    
    ?>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Ranking', 'ranking');
    echo form_input(array('name' => 'ranking',
        'id' => 'ranking',
        'value' => $resultaat->ranking,
        'class' => 'form-control',
        'required' => 'required'));
    
    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Ronde', 'rondetype');
    echo form_dropdown('rondetype', $rondetypeOpties);
    
    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Zwemmer', 'zwemmer');
    echo form_dropdown('zwemmer', $zwemmerOpties);
    
    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Tijd', 'tijd');
    echo form_input(array('name' => 'tijd',
        'id' => 'tijd',
        'value' => $resultaat->tijd,
        'class' => 'form-control',
        'pattern' => '^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$',
        'data-error' => 'Niet correct ingevuld! (xx:xx:xx)',
        'required' => 'required',));
    
    ?>
        <div class="help-block with-errors"></div>
        </div>
    <?php
    
    echo form_hidden('id', $resultaat->id);
    echo form_hidden('wedstrijddeelnameId', $wedstrijddeelname->id);
    echo '<div>';
    echo '</br>';
    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
    echo form_close();

    echo anchor($this->config->site_url() . '/trainer/Wedstrijdresultaat/resultaten/', 'Annuleren', 'class="btn btn-warning"');
    echo '</div>';
    ?>

</div>