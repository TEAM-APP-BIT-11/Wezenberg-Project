
<?php
/**
 * @file supplement_aanpassen.php
 * @author Ruben Tuytens
 *
 * View waar een voedingssupplement wordt weergegeven en kan worden aangepast 
 * - krijgt een $supplement-object binnen
 */
?>


<form action="<?php echo site_url() ;?>/trainer/supplement/voedingOpslaan" method="post">
<?php
echo "<h2>" . $titel ."</h2>";
echo "<div>";
echo form_label('Doelstelling supplement:', 'doelstelling'); 
echo form_input('doelstelling', $supplement->doelstelling->doelstelling, 'class="form-control" disabled');
echo "</div>";
echo "<div>";
echo form_label('Naam supplement:', 'voedingssupplement'); 
echo form_input('voedingssupplement', $supplement->naam, 'class="form-control"');
echo "</div>";
echo form_hidden('supplementId', $supplement->id);
echo form_hidden('doelstellingId', $supplement->doelstellingId);
?>
<button name ="opslaan" type="submit" value="submit" class="btn btn-primary">Wijziging opslaan</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'Annuleren', 'class="btn btn-primary"')) ;?>
