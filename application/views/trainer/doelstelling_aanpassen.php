
<form action="<?php echo site_url() ;?>/trainer/supplement/opslaan" method="post">
<?php
echo "<h2>" . $title ."</h2>";
echo "<div>";
echo form_label('Doelstelling supplement:', 'doelstelling'); 
echo form_input('doelstelling', $supplement->doelstelling, 'class="form-control"');
echo "</div>";

echo form_hidden('doelstellingId', $supplement->id);

?>
<button name ="opslaan" type="submit" value="submit" class="btn btn-primary">Wijziging opslaan</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'Annuleren', 'class="btn btn-primary"')) ;?>
