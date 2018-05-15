
<?php
/**
 * @file wedstrijdaanvraag_goedkeuren.php
 * @author Ruben Tuytens
 *
 * View waar alle wedstrijddeelnamens worden weergegeven van de zwemmers die nog niet/wel zijn goedgekeurd
 * - krijgt een $personen-object binnen
 * - krijgt een $alles-object binnen
 */
?>

<h1><?php echo $titel ;?></h1>
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
            echo "<tr><td>".$deel->wedstrijd->naam . ' '.date("d/m/Y",strtotime($deel->wedstrijd->begindatum))."</td>";
            echo "<td>".$deel->slag->naam. "</td>" ;
            echo "<td>".$deel->afstand->afstand . "</td>";
            if($deelname->statusId ==1)
            {
                echo "<td>".anchor(('trainer/wedstrijdaanvraag/goedkeuren/'.$deelname->id),form_button('goedkeuren', 'Goedkeuren', 'class="btn btn-success"')). "</td>";
             echo "<td>".anchor(('trainer/wedstrijdaanvraag/afwijzen/'.$deelname->id),form_button('afwijzen', 'Afwijzen', 'class="btn btn-danger"')). "</td>";
              echo "<td>".anchor(('trainer/wedstrijdaanvraag/wijzigen/'.$deelname->id),form_button('wijzigen', 'Wijzigen', 'class="btn btn-warning"')). "</td> </tr>";
            }
           elseif($deelname->statusId ==2)
           {
             echo "<td>Is goedkgekeurd</td><td>".anchor(('trainer/wedstrijdaanvraag/afwijzen/'.$deelname->id),form_button('afwijzen', 'Afwijzen', 'class="btn btn-danger"')). "</td>"; 
             echo "<td>".anchor(('trainer/wedstrijdaanvraag/wijzigen/'.$deelname->id),form_button('wijzigen', 'Wijzigen', 'class="btn btn-warning"')). "</td> </tr>";
            }
           
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

