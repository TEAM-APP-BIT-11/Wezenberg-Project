<?php if(validation_errors()){?>
<div class="alert alert-warning">
<?php echo validation_errors(); ?>
</div>
<?php } ?>
<form action="<?php echo site_url() ;?>/trainer/supplement/supplementToevoegen" method="post">
<?php
echo "<h2>" . $title ."</h2>";
echo '<div class="form-group">';
echo form_label('Naam supplement:', 'supplement');
echo form_input('supplement', set_value('supplement'), 'class="form-control"');
echo "</div>";
$options[0] = '-- select --';

foreach($doelstellingen as $doelstelling)
{
    $options[$doelstelling->id] = $doelstelling->doelstelling;
}
echo '<div class="form-group">';



echo form_label('Naam doelstelling:', 'doelstelling');


echo form_dropdown('doelstelling', $options, $doelstellinga, 'class="form-control"');
echo '</div>';
echo form_hidden('supplementId', 0);
?>
<button name ="toevoegen" type="submit" value="submit" class="btn btn-primary">Toevoegen</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'Annuleren', 'class="btn btn-primary"')) ;
        
       ;?>
