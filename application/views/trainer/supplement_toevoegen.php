<form action="<?php echo site_url() ;?>/trainer/supplement/supplementToevoegen" method="post">
<?php
echo "<h2>" . $title ."</h2>";
echo "<div>";

echo form_label('Naam supplement:', 'supplement');
echo form_input('supplement');
echo "</div>";
$options[0] = '-- select --';

foreach($doelstellingen as $doelstelling)
{
    $options[$doelstelling->id] = $doelstelling->doelstelling;
}
echo '<div>';
echo form_label('Naam doelstelling:', 'doelstelling');
echo form_dropdown('doelstelling', $options);
echo '</div>';
echo form_hidden('supplementId', 0);
?>
<button name ="toevoegen" type="submit" value="submit" class="btn btn-primary">toevoegen</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'annuleren', 'class="btn btn-primary"')) ;?>