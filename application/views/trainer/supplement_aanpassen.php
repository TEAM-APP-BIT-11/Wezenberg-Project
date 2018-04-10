
<form action="<?php echo site_url() ;?>/trainer/supplement/voedingOpslaan" method="post">
<?php
echo "<h2>" . $title ."</h2>";
echo "<div>";
echo form_label('Doelstelling supplement:', 'doelstelling'); 
echo form_input('doelstelling', $supplement->doelstelling->doelstelling, 'disabled');
echo "</div>";
echo "<div>";
echo form_label('Naam supplement:', 'voedingssupplement'); 
echo form_input('voedingssupplement', $supplement->naam);
echo "</div>";
echo form_hidden('supplementId', $supplement->id);
echo form_hidden('doelstellingId', $supplement->doelstellingId);
?>
<button name ="opslaan" type="submit" value="submit" class="btn btn-primary">Wijziging opslaan</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'annuleren', 'class="btn btn-primary"')) ;?>
