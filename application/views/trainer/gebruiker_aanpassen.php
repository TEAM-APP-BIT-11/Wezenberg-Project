<?php
/**
 * @file gebruiker_aanpassen.php
 * @author Dieter Verboven
 * View waarin de admin een nieuwe gebruiker kan toevoegen
 * - toont een leeg formulier
 * - systeem toont een foutmelding als de invoercontrole niet correct is.
 */
?>

<div class="col-md-10 content">

    <h1 class="">Gebruiker aanpassen</h1>
    <hr>
   
    <?php
    foreach ($types as $type) {
        $typeOpties[$type->id] = $type->typePersoon;
    }
    
    $attributes = array('name' => 'wedstrijdResultaatAanpassenFormulier', 'data-toggle' => 'validator', 'role' => 'form');
    echo form_open('trainer/gebruiker/pasAan', $attributes);

    echo form_labelpro('Type gebruiker:', 'type');
    echo form_dropdown('type', $typeOpties);

    echo '</br>';
    
    ?>
    
    <div class="form-group">

    <?php
    
    echo form_labelpro('Voornaam', 'voornaam');
    echo form_input(array('name' => 'voornaam',
        'id' => 'voornaam',
        'value' => $persoon->voornaam,
        'class' => 'form-control',
        'required' => 'required'));

     ?>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Familienaam', 'familienaam');
    echo form_input(array('name' => 'familienaam',
        'id' => 'familienaam',
        'value' => $persoon->familienaam,
        'class' => 'form-control',
        'required' => 'required'));

     ?>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Geboortedatum', 'geboortedatum');
    echo form_input(array('name' => 'geboortedatum',
        'id' => 'geboortedatum',
        'value' => $persoon->geboortedatum,
        'class' => 'form-control',
        'required' => 'required',
        'type' => 'date'));

     ?>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Straat', 'straat');
    echo form_input(array('name' => 'straat',
        'id' => 'straat',
        'value' => $persoon->straat,
        'class' => 'form-control'));

     ?>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Huisnummer', 'nummer');
    echo form_input(array('name' => 'nummer',
        'id' => 'nummer',
        'value' => $persoon->nummer,
        'type' => 'number',
        'data-error' => 'Dit is geen nummer.',
        'class' => 'form-control'));

     ?>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Postcode', 'postcode');
    echo form_input(array('name' => 'postcode',
        'id' => 'postcode',
        'value' => $persoon->postcode,
        'type' => 'number',
        'data-error' => 'Dit is geen postcode.',
        'class' => 'form-control'));

     ?>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Woonplaats', 'woonplaats');
    echo form_input(array('name' => 'woonplaats',
        'id' => 'woonplaats',
        'value' => $persoon->woonplaats,
        'class' => 'form-control'));

     ?>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('E-mailadres', 'mailadres');
    echo form_input(array('name' => 'mailadres',
        'id' => 'mailadres',
        'value' => $persoon->mailadres,
        'type' => 'email',
        'class' => 'form-control',
        'data-error' => 'Dit is geen email.',
        'required' => 'required'));

     ?>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Gsmnummer', 'gsmnummer');
    echo form_input(array('name' => 'gsmnummer',
        'id' => 'gsmnummer',
        'value' => $persoon->gsmnummer,
        'class' => 'form-control'));
    
     ?>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Biografie', 'biografie');
    echo form_textarea(array('name' => 'biografie',
        'id' => 'biografie',
        'class' => 'form-control',
        'value' => $persoon->biografie));

     ?>
        </div>
        <div class="form-group">
    <?php
   
    
    echo form_labelpro('Gebruikersnaam', 'gebruikersnaam');
    echo form_input(array('name' => 'gebruikersnaam',
        'id' => 'gebruikersnaam',
        'value' => $persoon->gebruikersnaam,
        'class' => 'form-control',
        'required' => 'required'));
    
     ?>
        </div>
    <?php
   
    echo form_hidden('id', $persoon->id);
    echo '<div>';
    echo '</br>';
    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
    echo form_close();
    echo anchor('trainer/gebruiker/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"'));
    echo '</div></br>';
    
    ?>

</div>
