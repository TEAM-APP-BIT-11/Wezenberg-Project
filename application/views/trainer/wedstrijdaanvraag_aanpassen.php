<?php
echo '<h2>'.$title.'</h2>';
echo '<h3>Wedstrijd: '.$deelname->wedstrijd->naam .'</h3>';
echo '<h4>Zwemmer: '.$deelname->persoon->voornaam.'</h4>';?>
<form action="<?php echo site_url() ;?>/trainer/wedstrijdaanvraag/aanpassen" method="post">
<?php
echo form_label('Verschillende slagen', 'slagen');
echo '</br>';
$options[0]= '-- Select --';
foreach($deelname->reeksen as $reeks)
{
    
        $options[$reeks->slagId] = $reeks->slag->naam;
    
  
}
echo "<tr> <td>";
echo form_label('Slag:', 'slag');
echo "</td> <td>";
echo form_dropdown('slag', $options);
echo "</td></tr>";

$opties[0]= '-- Select --';
foreach($deelname->reeksen as $reeks)
{
    
        $opties[$reeks->afstandId] = $reeks->afstand->afstand;
    
  
}
echo "<tr> <td>";
echo form_label('Afstand:', 'afstand');
echo "</td> <td>";
echo form_dropdown('afstand', $opties);
echo "</td></tr>";

?>
<button name ="aanpassen" type="submit" value="submit" class="btn btn-primary">Aanpassen</button>
<?php echo anchor('trainer/supplement/beheren', form_button('back', 'annuleren', 'class="btn btn-primary"')) ;?>
