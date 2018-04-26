


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
           echo '<h3>'.$deelname->resultaat->rondetype->type.'</h3>';
        foreach($personen as $persoon)
        {
            if($persoon->id == $deelname->persoonId)
            {
                echo '<table class="table">';
                echo '<tr><th>Zwemmer</th><th>Tijd</th><th>Ranking</th></tr><tr>';
                echo '<td>' . $persoon->familienaam .' '.$persoon->voornaam.'</td>';
                echo '<td>' . $deelname->resultaat->tijd.'</td>';
                echo '<td>' . $deelname->resultaat->ranking.'de</td>';
                echo '</tr></table>';
            }
        } 
        }
        
    }
}



