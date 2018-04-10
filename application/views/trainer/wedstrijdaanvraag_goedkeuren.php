


<h1>Wedstrijdaanvragen beheren</h1>
<style>
    th{
        width: 300px;
        
    }
</style>

    
<?php
$vorigepersoon ="";
$teller =0;
foreach($personen as $persoon)
{
    
     foreach($alles as $deel)
    {
        
        foreach($deel->deelnames as $deelname)
    {
       
        if($deelname->persoonId == $persoon->id )
        {
            if($persoon->voornaam != $vorigepersoon)
             
        {
            echo '</table>';
            echo "<h2>" . $persoon->voornaam . "</h2>";
            echo '<table class="table">';
            echo '<th >wedstrijd</th><th>slag</th><th colspan=4>afstand</th>';
            
        }
            echo "<tr><td>".$deel->wedstrijd->naam . "</td>";
            echo "<td>".$deel->slag->naam. "</td>" ;
            echo "<td>".$deel->afstand->afstand . "</td>";
            echo "<td>".anchor(('trainer/wedstrijdaanvraag/goedkeuren/'.$deelname->id),'goedkeuren'). "</td>";
             echo "<td>".anchor(('trainer/wedstrijdaanvraag/afwijzen/'.$deelname->id),'afwijzen'). "</td>";
              echo "<td>".anchor(('trainer/wedstrijdaanvraag/wijzigen/'.$deelname->id),'wijzigen'). "</td> </tr>";
            $vorigepersoon = $persoon->voornaam;
            
            $teller++;
        }
        
    }
    }
    }
   if($teller ==0)
   {
       echo "<h1>Er zijn momenteel geen wedstrijdaanvragen</h1>";
   }

echo "</table>";

