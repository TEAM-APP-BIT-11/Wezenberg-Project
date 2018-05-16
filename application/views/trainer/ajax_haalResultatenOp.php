<?php
/**
 * @file wedstrijd_resultaat.php
 * @author Dieter Verboven
 *
 * View waar alle resultaten van een reeks worden getoond
 * - krijgt $resultaat-objecten en $persoon-objecten binnen
 */
?>
<div class="table-responsive">

            
            
<?php
if(empty($wedstrijddeelnames))
    {
        echo "<p>Er zijn nog geen resultaten</p>";
    }
 else {
    echo '<table class="table">
             <tr class="active">
                 <td><label for="type">Ronde</label></td>
                 <td><label for="type">Ranking</label></td>
                 <td><label for="type">Zwemmer</label></td>
                 <td><label for="type">Resultaat</label></td>
                 <td><label for="type">Actie</label></td>
             </tr>';
     foreach($wedstrijddeelnames as $wedstrijddeelname)
     {

         if (isset($wedstrijddeelname->resultaatId))
         {
             echo "<tr><td> " . ucfirst($wedstrijddeelname->resultaat->rondetype->type) . "</td>"; 
             echo "<td> " . $wedstrijddeelname->resultaat->ranking . "</td>";
             echo "<td> " . ucfirst($wedstrijddeelname->persoon->voornaam) . "</td>";
             echo "<td> " . $wedstrijddeelname->resultaat->tijd . "</td>"; 
             echo "<td>" . anchor('trainer/wedstrijdresultaat/resultatenaanpassen/' . $wedstrijddeelname->resultaatId, 'Aanpassen') . "</td></tr>";
         }
         else
         {
             echo "<tr><td> leeg </td>"; 
             echo "<td> 0 </td>";
             echo "<td> " . ucfirst($wedstrijddeelname->persoon->voornaam) . "</td>";
             echo "<td> leeg </td>"; 
             echo "<td>" . anchor('trainer/wedstrijdresultaat/resultatenaanpassen/' . $wedstrijddeelname->resultaatId, 'Aanpassen') . "</td></tr>";
         }
     }
 }
    
    
?>
</table>
</div>