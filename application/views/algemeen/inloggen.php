<?php

/**
 * Inlogformulier om in te loggen op de webapplicaite
 */

$attributes = array('name' => 'mijnFormulier', 'class' => 'form-signin');
echo form_open('Algemeen/controleerAanmelden', $attributes);
?>
<div class="wrapper">
    <h2 class="form-signin-heading">Inloggen</h2>
    <hr class="colorgraph">
    <p></p>
    <br>
    <?php echo form_label('Gebruikersnaam:', 'gebruikersnaam'); ?>
    <?php $gebruikersnaam = array('name' => 'gebruikersnaam', 'id' => 'gebruikersnaam', 'size' => '30', 'required' => 'required', 'placeholder' => 'Gebruikersnaam', 'class' => 'form-control'); ?>
    <?php echo form_input($gebruikersnaam); ?>

    <?php echo form_label('Wachtwoord:', 'wachtwoord'); ?>
    <?php
    $data = array('name' => 'wachtwoord', 'id' => 'wachtwoord', 'size' => '30', 'required' => 'required', 'placeholder' => 'Wachtwoord', 'class' => 'form-control');
    echo form_password($data);
    ?>

    <td><?php echo form_submit('knop', 'Inloggen', 'class="btn btn-lg btn-primary btn-block"'); ?></td>

    <?php echo form_close(); ?>
</div>
