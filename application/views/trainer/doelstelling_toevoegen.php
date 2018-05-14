<?php if(validation_errors()){?>
<div class="alert alert-warning">
<?php echo validation_errors(); ?>
</div>
<?php } ?>
<form  action="<?php echo site_url() ;?>/trainer/supplement/toevoegen"  method="post">

    <?php
echo "<h2>" . $title ."</h2>";
echo '<div class="form-group">';

echo form_label('Doelstelling supplement:', 'doelstelling'); 
echo form_input('doelstelling', '', 'class="form-control" ');
echo '</div>';

echo form_hidden('doelstellingId', 0);
?>

<button name ="toevoegen" type="submit" value="submit" class="btn btn-primary">Toevoegen</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'Annuleren', 'class="btn btn-primary"')) ;?>