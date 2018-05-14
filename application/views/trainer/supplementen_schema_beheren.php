<?php

echo "<h2>". $title."</h2>";
$vorigepersoon ="";
echo '<table>';
foreach($personen as $persoon)
{
    
     foreach($innames as $inname)
    {
        
       
       
        if($inname->persoonId == $persoon->id )
        {
            
            if($persoon->voornaam != $vorigepersoon){
                 
                echo '</table>';
             echo "<h2>" . $persoon->voornaam ."</h2>";
             echo '<table class="table"> <tr> <th>Datum</th> <th>Supplement</th> <th colspan="3">Aantal</th></tr>';
            }
           echo "<tr>";

           $date = DateTime::createFromFormat("Y-m-d", $inname->datum);

           echo '<td width="33%">'.date("l d/m/Y",strtotime($inname->datum)) ."</td>"; 
           echo '<td width="25%">'.$inname->voedingssupplement->naam."</td>";
           echo '<td width="10%">'.$inname->aantal."</td>";
           echo "<td>".anchor(('/trainer/supplementschema/aanpassen/'. $inname->id),form_button('aanpassen', 'Aanpassen', 'class="btn btn-warning"'))."</td>";
           echo "<td>".anchor(('/trainer/supplementschema/verwijderen/'. $inname->id),form_button('verwijderen', 'Verwijderen', 'class="btn btn-danger"'))."</td>";   
           echo "</tr>";
           $vorigepersoon =$persoon->voornaam;
        }
        
    }
    
}
echo "</table>";
echo anchor('trainer/supplementschema/toevoegen', form_button('toevoegen', 'Toevoegen', 'class="btn btn-primary"')) ;
        echo anchor('trainer/home/index', form_button('back', 'Annuleren', 'class="btn btn-primary"'));?>
 
