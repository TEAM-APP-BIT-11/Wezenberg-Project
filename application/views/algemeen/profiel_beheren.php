<?php
/**
 * @file profiel_beheren.php
 * @author Dieter Verboven
 * View waarin de gebruiker zijn/haar gegevens kan aanpassen.
 * - krijgt $persoon binnen van de ingelogde persoon.
 */
?>

<div class="col-md-10 content">


    <?php
    $attributen = array('name' => 'mijnFormulier', 'data-toggle' => 'validator', 'role' => 'form');
    echo form_open('welcome/registreer', $attributen);
    echo form_hidden('id', $persoon->id);
    ?>
    <h1>Profiel beheren</h1>
    <?php echo "<h3>" . ucwords($persoon->voornaam . " " . $persoon->familienaam) . "</h3>" ;

    ?>
        <div class="form-group">
    <?php

    echo form_labelpro('Voornaam:', 'voornaam');
    echo form_input(array('name' => 'voornaam',
        'id' => 'voornaam',
        'value' => $persoon->voornaam,
        'class' => 'form-control',
        'required' => 'required'));

    ?>
        </div>
        <div class="form-group">
    <?php

    echo form_labelpro('Familienaam:', 'familienaam');
    echo form_input(array('name' => 'familienaam',
        'id' => 'familienaam',
        'value' => $persoon->familienaam,
        'class' => 'form-control',
        'required' => 'required'));

    ?>
        </div>
        <div class="form-group">
    <?php

    echo form_labelpro('Straat:', 'straat');
    echo form_input(array('name' => 'straat',
        'id' => 'straat',
        'value' => $persoon->straat,
        'class' => 'form-control'));

    ?>
        </div>
        <div class="form-group">
    <?php

    echo form_labelpro('Nummer:', 'nummer');
    echo form_input(array('name' => 'nummer',
        'id' => 'nummer',
        'value' => $persoon->nummer,
        'type' => 'number',
        'data-error' => 'Dit is geen nummer.',
        'class' => 'form-control'));

    ?>
        </div>
        <div class="form-group">
    <?php

    echo form_labelpro('E-mailadres:', 'mailadres');
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

    echo form_labelpro('Telefoonnummer:', 'gsmnummer');
    echo form_input(array('name' => 'gsmnummer',
        'id' => 'gsmnummer',
        'value' => $persoon->gsmnummer,
        'class' => 'form-control'));

    ?>
        </div>
        <div class="form-group">
    <?php

    echo form_labelpro('Gemeente:', 'gemeente');
    echo form_input(array('name' => 'gemeente',
        'id' => 'gemeente',
        'value' => $persoon->woonplaats,
        'class' => 'form-control'));
    ?>
        </div>
        <div class="form-group">
    <?php

    echo form_labelpro('Postcode:', 'postcode');
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

    echo form_labelpro('Biografie:', 'biografie');
    echo form_textarea(array('name' => 'biografie',
        'id' => 'biografie',
        'class' => 'form-control',
        'value' => $persoon->biografie));

    ?>
        </div>
        <div class="form-group">
    <?php

    echo form_labelpro('Foto:', 'foto');
    echo form_upload('foto', 'foto', 'size=50', array("style" => "height:50px"));

    ?>
        </div>
        <div class="form-group">
    <?php

    echo form_submit('knop', 'Wijzig');

    echo form_close(); ?>

    <p><?php

        echo "<p>" . anchor('welcome/wachtwoord/' . $persoon->id, "Wachtwoord wijzigen") . "</p>";
        
        if($persoon->typePersoonId == 1)
        {
            echo "<p>" . anchor('trainer/home', "Terug") . "</p>";
        }
        else
        {
            echo "<p>" . anchor('zwemmer/home', "Terug") . "</p>";
        }

        ?></p>
</div>


