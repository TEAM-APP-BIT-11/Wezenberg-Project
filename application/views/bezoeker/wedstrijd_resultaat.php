


    

<?php
/**
 * @file wedstrijd_resultaat.php
 * @author Ruben Tuytens
 *
 * View waar alle wedstrijden worden weergegeven 
 * - krijgt een $wedstrijden-object binnen
 */

echo "<h2>" . $titel . "</h2>";
echo '<table class="table">';
foreach ($wedstrijden as $wedstrijd)
{
    echo '<tr><td>';
    echo $wedstrijd->naam . '</td> <td>';
    echo $wedstrijd->begindatum . '</td> <td>';
    echo $wedstrijd->einddatum . '</td>';
    echo '<td>'.anchor(('/bezoeker/home/resultaatDetail/'. $wedstrijd->id),'wedstrijd bekijken')."</td>";
              
}
echo '</table>';
echo anchor('/bezoeker/home', form_button('back', 'Terug', 'class="btn btn-primary"')) 
?>
</table>