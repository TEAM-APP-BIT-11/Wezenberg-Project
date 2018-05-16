<?php
/**
 * @file gebruiker_aanpassen.php
 * @author Dieter Verboven
 * View waarin de admin een gebruiker kan aanpassen
 * - toont een $persoon-object in een formulier
 * - systeem toont een foutmelding als de invoercontrole niet correct is.
 */
?>

<script>

    $(document).ready(function () {
        
        $(".btnToevoegen").hide();
        $("#success").hide();
        
        $('#type').change(function() {
                     
            var e = document.getElementById("type");
            var type = e.options[e.selectedIndex].text;
    
            if (type === "trainer")
            {
                $('.text').html("Automatisch paswoord: trainer123")
                $(".password").show();
            }
            else if (type === "zwemmer")
            {
                $('.text').html("Automatisch paswoord: zwemmer123")
                $(".password").show();
            }
        });
        
    });

</script>

<div class="col-md-10 content">

    <h1 class="">Gebruiker toevoegen</h1>
    <hr>
   
    <?php
    foreach ($types as $type) {
        $typeOpties[$type->id] = $type->typePersoon;
    }

    $attributes = array('name' => 'gebruikerAanpassenFormulier', 'data-toggle' => 'validator', 'role' => 'form');
    echo form_open('trainer/gebruiker/voegToe', $attributes);

    echo form_labelpro('Type gebruiker:', 'type');
    echo form_dropdown('type', $typeOpties,'', 'id="type"');

    echo '</br>';
    ?>
    
    <div class="form-group">

    <?php
    echo form_labelpro('Voornaam', 'voornaam');
    echo form_input(array('name' => 'voornaam',
        'id' => 'voornaam',
        'class' => 'form-control',
        'required' => 'required'));

    ?>
        </div>
        <div class="form-group">
    <?php
   
    echo form_labelpro('Familienaam', 'familienaam');
    echo form_input(array('name' => 'familienaam',
        'id' => 'familienaam',
        'class' => 'form-control',
        'required' => 'required'));
    ?>
        </div>
        <div class="form-group">
    <?php
    echo form_labelpro('Geboortedatum', 'geboortedatum');
    echo form_input(array('name' => 'geboortedatum',
        'id' => 'geboortedatum',
        'class' => 'form-control',
        'type' => 'date'));

    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Straat', 'straat');
    echo form_input(array('name' => 'straat',
        'id' => 'straat',
        'class' => 'form-control'));

    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Huisnummer', 'nummer');
    echo form_input(array('name' => 'nummer',
        'id' => 'nummer',
        'type' => 'number',
        'class' => 'form-control'));

    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Postcode', 'postcode');
    echo form_input(array('name' => 'postcode',
        'id' => 'postcode',
        'type' => 'number',
        'class' => 'form-control'));

    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Woonplaats', 'woonplaats');
    echo form_input(array('name' => 'woonplaats',
        'id' => 'woonplaats',
        'class' => 'form-control'));

    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('E-mailadres', 'mailadres');
    echo form_input(array('name' => 'mailadres',
        'id' => 'mailadres',
        'type' => 'email',
        'class' => 'form-control',
        'data-error' => 'Dit is geen email.',
        'required' => 'required'));
    echo '<div class="help-block with-errors"></div>';
    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Gsmnummer', 'gsmnummer');
    echo form_input(array('name' => 'gsmnummer',
        'id' => 'gsmnummer',
        'class' => 'form-control'));
    
    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Biografie', 'gebruikersnaam');
    echo form_textarea(array('name' => 'biografie',
        'id' => 'biografie',
        'class' => 'form-control'));

    ?>
        </div>
        <div class="form-group">
    <?php
    
    echo form_labelpro('Gebruikersnaam', 'gebruikersnaam');
    echo form_input(array('name' => 'gebruikersnaam',
        'id' => 'gebruikersnaam',
        'class' => 'form-control',
        'required' => 'required'));

    ?>
        </div>
    </br>
    <div class="password">
        <p class="text">Automatisch paswoord: trainer123</p>
    </div>
    
    <?php
    echo '<div>';
    echo '</br>';
    echo form_submit('knop', 'Voeg toe', 'class="btn btn-primary"');
    echo form_close();

    echo anchor('trainer/gebruiker/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"'));
    echo '</div></br>';
    ?>

</div>
