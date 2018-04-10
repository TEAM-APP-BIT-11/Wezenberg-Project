
<form action="<?php echo site_url() ;?>/trainer/supplement/toevoegen" method="post">

    <?php
echo "<h2>" . $title ."</h2>";
echo "<div>";
echo form_label('Doelstelling supplement:', 'doelstelling'); 
echo form_input('doelstelling');
echo "</div>";

echo form_hidden('doelstellingId', 0);
?>
<button name ="toevoegen" type="submit" value="submit" class="btn btn-primary">toevoegen</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'annuleren', 'class="btn btn-primary"')) ;?>