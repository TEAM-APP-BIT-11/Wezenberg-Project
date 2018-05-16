
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

?>
<a href="javascript:history.go(-1);">
    <button type="button" class="btn btn-primary">Terug</button>
</a>

</table>