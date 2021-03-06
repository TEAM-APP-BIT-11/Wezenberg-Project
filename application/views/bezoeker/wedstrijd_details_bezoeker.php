<?php
/**
 * @file wedstrijd_details_bezoeker.php
 * @author Ruben Tuytens
 *
 * View waar de resultaten van een wedstrijd worden weergegeven
 * - krijgt een $wedstrijdnaam-object binnen
 * - krijgt een $slagen-object binnen
 * - krijgt een $deelnamens-object binnen
 */
?>


<h1>Wedstrijdresultaten bekijken</h1>
<style>
    th{
        width: 300px;
        
    }
</style>

    
<?php
$vorigeslag ="";
$teller =0;
echo '<h2>' . $wedstrijdnaam->naam.'</h2>';
foreach($slagen as $slag)
{
    echo '<h2>'.$slag->slag->naam . ' '.$slag->afstand->afstand. '</h2>';
    
    foreach($deelnamens as $deelname)
    {
        
        if($slag->id == $deelname->wedstrijdReeksId)
        {
            if(isset($deelname->resultaat))
            {
               echo '<h3>'.$deelname->resultaat->rondetype->type.'</h3>'; 
               foreach($personen as $persoon)
        {
            if($persoon->id == $deelname->persoonId)
            {
                if ($deelname->resultaat->tijd != "00:00:00")
                {
                    echo '<table class="table">';
                echo '<tr><th>Zwemmer</th><th>Tijd</th><th>Ranking</th></tr><tr>';
                echo '<td>' . $persoon->familienaam .' '.$persoon->voornaam.'</td>';
                echo '<td>' . $deelname->resultaat->tijd.'</td>';
                
                if ($deelname->resultaat->ranking == 1)
                {
                    echo '<td>' . $deelname->resultaat->ranking.'ste</td>';
                }
                else
                {
                    echo '<td>' . $deelname->resultaat->ranking.'de</td>';
                }
                
                echo '</tr></table>';
                }
                
                
            }
        } 
            }
          
        
        }
        
    }
}
echo anchor('/bezoeker/home/resultaten', form_button('back', 'Terug', 'class="btn btn-primary"')) ;