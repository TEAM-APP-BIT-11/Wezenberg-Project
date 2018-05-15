<div class="col-md-10 content">

    <h1 class="">Wedstrijdresultaat toevoegen - <?php echo $reeks->wedstrijd->naam . " - " . $reeks->afstand->afstand . " meter " . $reeks->slag->naam ?></h1>
    <hr>

    <?php
    foreach ($rondetypes as $rondetype) {
        $rondetypeOpties[$rondetype->id] = $rondetype->type;
    }
    
    foreach ($zwemmers as $zwemmer) {
        $zwemmerOpties[$zwemmer->id] = $zwemmer->voornaam;
    }
    $attributes = array('name' => 'wedstrijdResultaatToevoegenFormulier', 'data-toggle' => 'validator', 'role' => 'form');
    echo form_open('trainer/wedstrijdresultaat/aanmaken', $attributes);
    ?>
    <div class="form-group">
    <?php
    
    echo form_labelpro('Ranking', 'ranking');
    echo form_input(array('name' => 'ranking',
        'id' => 'ranking',
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
        'pattern' => '^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$',
        'data-error' => 'Niet correct ingevuld! (xx:xx:xx)',
        'class' => 'form-control',
        'required' => 'required',));
    
    ?>
        <div class="help-block with-errors"></div>
        </div>
    
    <?php
    echo form_hidden('reeksId', $reeks->id);
    echo form_hidden('wedstrijdId', $reeks->wedstrijdId);
    echo '<div>';
    echo '</br>';
    echo form_submit('knop', 'Toevoegen', 'class="btn btn-primary"');
    echo form_close();

    echo anchor($this->config->site_url() .'/trainer/Wedstrijdresultaat/resultatenbeheren/' . $reeks->wedstrijdId, form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;
    echo '</div>';
    ?>



</div>