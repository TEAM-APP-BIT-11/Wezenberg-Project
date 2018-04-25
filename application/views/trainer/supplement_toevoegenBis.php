<div class="col-md-10 content">

    <h1 class="">Supplementen beheren</h1>
    <hr>
    <h3>Supplement toevoegen</h3>

    <?php
    foreach ($doelstellingen as $doelstelling) {
        $doelstellingOpties[$doelstelling->id] = $doelstelling->doelstelling;
    }

    $attributes = array('name' => 'supplementAanpasFormulier');
    echo form_open('trainer/supplement/aanmakenBis', $attributes);

    echo form_labelpro('Naam', 'naam');
    echo form_input(array('name' => 'naam',
        'id' => 'naam',
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    echo form_labelpro('Doelstelling', 'doelstelling');
    echo form_dropdown('doelstelling', $doelstellingOpties);

    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
    echo form_close();
    ?>
    <?php echo anchor('trainer/Supplement/beherenBis', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;?>
</div>
