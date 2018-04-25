<div class="col-md-10 content">

    <h1 class="">Gebruiker aanpassen</h1>
    <hr>
   
    <?php
    foreach ($types as $type) {
        $typeOpties[$type->id] = $type->typePersoon;
    }

    $attributes = array('name' => 'gebruikerAanpassenFormulier');
    echo form_open('trainer/gebruiker/pasAan', $attributes);

    echo form_labelpro('Type gebruiker:', 'type');
    echo form_dropdown('type', $typeOpties);

    echo '</br>';
    
    echo form_labelpro('Voornaam', 'voornaam');
    echo form_input(array('name' => 'voornaam',
        'id' => 'voornaam',
        'value' => $persoon->voornaam,
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    
    echo form_labelpro('Familienaam', 'familienaam');
    echo form_input(array('name' => 'familienaam',
        'id' => 'familienaam',
        'value' => $persoon->familienaam,
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    echo form_labelpro('Geboortedatum', 'geboortedatum');
    echo form_input(array('name' => 'geboortedatum',
        'id' => 'geboortedatum',
        'value' => $persoon->geboortedatum,
        'class' => 'form-control',
        'required' => 'required',
        'type' => 'date'));


    echo form_labelpro('Straat', 'straat');
    echo form_input(array('name' => 'straat',
        'id' => 'straat',
        'value' => $persoon->straat,
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('Huisnummer', 'nummer');
    echo form_input(array('name' => 'nummer',
        'id' => 'nummer',
        'value' => $persoon->nummer,
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('Postcode', 'postcode');
    echo form_input(array('name' => 'postcode',
        'id' => 'postcode',
        'value' => $persoon->postcode,
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('Woonplaats', 'woonplaats');
    echo form_input(array('name' => 'woonplaats',
        'id' => 'woonplaats',
        'value' => $persoon->woonplaats,
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('E-mailadres', 'mailadres');
    echo form_input(array('name' => 'mailadres',
        'id' => 'mailadres',
        'value' => $persoon->mailadres,
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    
    echo form_labelpro('Gsmnummer', 'gsmnummer');
    echo form_input(array('name' => 'gsmnummer',
        'id' => 'gsmnummer',
        'value' => $persoon->gsmnummer,
        'class' => 'form-control'));

    echo '</br>';
    
    echo form_labelpro('Gebruikersnaam', 'gebruikersnaam');
    echo form_input(array('name' => 'gebruikersnaam',
        'id' => 'gebruikersnaam',
        'value' => $persoon->gebruikersnaam,
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';

    echo form_hidden('id', $persoon->id);
    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
    echo form_close();
    ?>
    <?php echo anchor('trainer/gebruiker/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;?>
    <footer>
    </footer>

</div>
