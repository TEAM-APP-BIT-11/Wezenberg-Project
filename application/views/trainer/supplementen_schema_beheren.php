<?php
/**
 * @file supplementen_schema_beheren.php
 * @author Ruben Tuytens
 *
 * View waar de innames van elke zwemmer wordt weergegeven.
 * - krijgt een $personen-object binnen
 * - krijgt een $innames-object binnen
 */

?>


<script type="text/javascript">
  
   
    $(document).ready(function () {
        
        $('[name="verwijderen"]').click(function(){
           $.confirm({
                title: 'Evenement annuleren',
                content: 'Bent u zeker dat u dit evenement wil annuleren?',
                buttons: {
                    Ja: function () {
                        window.location.href = site_url + '/trainer/Evenement/beheren';
                    },
                    Nee: function () {
                        $.alert('Het evenement werd niet geannuleerd.');
                    }
                }
            }); 
        });
    
})
</script>
    

<?php

echo "<h2>". $titel."</h2>";
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

          

           echo '<td width="33%">'.date("l d/m/Y",strtotime($inname->datum)) ."</td>"; 
           echo '<td width="25%">'.$inname->voedingssupplement->naam."</td>";
           echo '<td width="10%">'.$inname->aantal."</td>";
           echo "<td>".anchor(('/trainer/supplementschema/aanpassen/'. $inname->id),form_button('aanpassen', 'Aanpassen', 'class="btn btn-warning"'))."</td>";
           echo "<td>".anchor(('/trainer/supplementschema/verwijderen/'. $inname->id),form_button('verwijderen', 'Verwijderen', 'class="btn btn-danger" value="' . $inname->id.'"'))."</td>";   
           echo "</tr>";
           $vorigepersoon =$persoon->voornaam;
        }
        
    }
    
}

echo "</table>";
echo anchor('trainer/supplementschema/toevoegen', form_button('toevoegen', 'Toevoegen', 'class="btn btn-primary"')) ;
        echo anchor('trainer/home/index', form_button('back', 'Annuleren', 'class="btn btn-primary"'));?>
 
