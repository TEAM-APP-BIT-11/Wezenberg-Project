<div class="col-md-10 content">

    <h1 class="">Wedstrijdresultaat toevoegen</h1>
    <hr>

    <?php
    foreach ($rondetypes as $rondetype) {
        $rondetypeOpties[$rondetype->id] = $rondetype->type;
    }
    
    foreach ($zwemmers as $zwemmer) {
        $zwemmerOpties[$zwemmer->id] = $zwemmer->voornaam;
    }

    $attributes = array('name' => 'wedstrijdResultaatToevoegenFormulier');
    echo form_open('trainer/wedstrijdresultaat/aanmaken', $attributes);

    echo form_labelpro('Ranking', 'ranking');
    echo form_input(array('name' => 'ranking',
        'id' => 'ranking',
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    echo form_labelpro('Ronde', 'rondetype');
    echo form_dropdown('rondetype', $rondetypeOpties);
    
    echo '</br>';
    echo form_labelpro('Zwemmer', 'zwemmer');
    echo form_dropdown('zwemmer', $zwemmerOpties);

    echo '</br>';
    echo form_labelpro('Tijd (xx:xx:xx)', 'tijd');
    echo form_input(array('name' => 'tijd',
        'id' => 'tijd',
        'class' => 'form-control',
        'required' => 'required',));
    
    
    echo '<hr>';

    echo form_hidden('reeksId', $reeks->id);
    //echo form_hidden('wedstrijddeelnameId', $wedstrijddeelname->id);
    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
    echo form_close();
    ?>
    <?php echo anchor('trainer/Wedstrijdresultaat/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;?>
    <footer>
    </footer>

</div>
