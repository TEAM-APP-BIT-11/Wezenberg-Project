<?php

echo "<h2>".$title."</h2>";
$vorigepersoon ="";

foreach($personen as $persoon)
{
    
     foreach($innames as $inname)
    {
        
       
       
        if($inname->persoonId == $persoon->id )
        {
            
            if($persoon->voornaam != $vorigepersoon){
                 
                echo '</table>';
             echo "<h2>" . $persoon->voornaam ."</h2>";
             echo '<table class="table"> <tr> <th >Datum</th> <th>Supplement</th> <th colspan="3">Aantal</th></tr>';
            }
           echo "<tr>";
           $date = DateTime::createFromFormat("Y-m-d", $inname->datum);
           
           echo "<td>".$date->format("l").' '.date("m/d/Y",strtotime($inname->datum)) ."</td>"; 
           echo "<td>". $inname->voedingssupplement->naam."</td>";
           echo "<td>". $inname->aantal."</td>";
           echo "<td>".anchor(('/trainer/supplementschema/aanpassen/'. $inname->id),'aanpassen')."</td>";
            echo "<td>".anchor(('/trainer/supplementschema/verwijderen/'. $inname->id),'verwijderen')."</td>";   
           echo "</tr>";
           $vorigepersoon =$persoon->voornaam;
        }
        
    }
    
}
echo "</table>";
 echo anchor('trainer/supplementschema/toevoegen', form_button('toevoegen', 'toevoegen', 'class="btn btn-primary"'));
