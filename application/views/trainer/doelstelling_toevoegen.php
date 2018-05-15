<?php
/**
 * @file doelstelling_toevoegen.php
 * @author Ruben Tuytens
 *
 * View waar een supplementdoelstelling kan worden toegevoegd aan de hand van een formulier
 * - gebruikt codeigniter form_validation
 * - gebruikt Bootstrap-alerts
 */



if(validation_errors()){?>
<div class="alert alert-warning">
<?php echo validation_errors(); ?>
</div>
<?php } ?>
<form  action="<?php echo site_url() ;?>/trainer/supplement/toevoegen"  method="post">

    <?php
echo "<h2>" . $titel ."</h2>";
echo '<div class="form-group">';

echo form_label('Doelstelling supplement:', 'doelstelling'); 
echo form_input('doelstelling', '', 'class="form-control" ');
echo '</div>';

echo form_hidden('doelstellingId', 0);
?>

<button name ="toevoegen" type="submit" value="submit" class="btn btn-primary">Toevoegen</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'Annuleren', 'class="btn btn-primary"')) ;?>