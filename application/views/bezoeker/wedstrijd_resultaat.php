


    

<?php
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
echo anchor('/bezoeker/home', form_button('back', 'terug', 'class="btn btn-primary"')) 
?>
</table>