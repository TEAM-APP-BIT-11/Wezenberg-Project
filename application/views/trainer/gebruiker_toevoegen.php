<div class="col-md-10 content">

    <h1 class="">Gebruiker toevoegen</h1>
    <hr>
   
    <?php
    foreach ($types as $type) {
        $typeOpties[$type->id] = $type->typePersoon;
    }

    $attributes = array('name' => 'gebruikerAanpassenFormulier');
    echo form_open('trainer/gebruiker/voegToe', $attributes);

    echo form_labelpro('Type gebruiker:', 'type');
    echo form_dropdown('type', $typeOpties);

    echo '</br>';
    
    echo form_labelpro('Voornaam', 'voornaam');
    echo form_input(array('name' => 'voornaam',
        'id' => 'voornaam',
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    
    echo form_labelpro('Familienaam', 'familienaam');
    echo form_input(array('name' => 'familienaam',
        'id' => 'familienaam',
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    echo form_labelpro('Geboortedatum', 'geboortedatum');
    echo form_input(array('name' => 'geboortedatum',
        'id' => 'geboortedatum',
        'class' => 'form-control',
        'required' => 'required',
        'type' => 'date'));


    echo form_labelpro('Straat', 'straat');
    echo form_input(array('name' => 'straat',
        'id' => 'straat',
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('Huisnummer', 'nummer');
    echo form_input(array('name' => 'nummer',
        'id' => 'nummer',
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('Postcode', 'postcode');
    echo form_input(array('name' => 'postcode',
        'id' => 'postcode',
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('Woonplaats', 'woonplaats');
    echo form_input(array('name' => 'woonplaats',
        'id' => 'woonplaats',
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('E-mailadres', 'mailadres');
    echo form_input(array('name' => 'mailadres',
        'id' => 'mailadres',
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    
    echo form_labelpro('Gsmnummer', 'gsmnummer');
    echo form_input(array('name' => 'gsmnummer',
        'id' => 'gsmnummer',
        'class' => 'form-control'));
    
    echo '</br>';
    
    echo form_labelpro('Biografie', 'gebruikersnaam');
    echo form_textarea(array('name' => 'biografie',
        'id' => 'biografie',
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('Gebruikersnaam', 'gebruikersnaam');
    echo form_input(array('name' => 'gebruikersnaam',
        'id' => 'gebruikersnaam',
        'class' => 'form-control',
        'required' => 'required'));

    echo '<div>';
    echo '</br>';
    echo form_submit('knop', 'Voeg toe', 'class="btn btn-primary"');
    echo form_close();

    echo anchor('trainer/gebruiker/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"'));
    echo '</div></br>';
    ?>

</div>
