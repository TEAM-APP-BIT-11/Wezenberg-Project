<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<table class="table">
            <tr class="active">
                <td><label for="type">Ronde</label></td>
                <td><label for="type">Ranking</label></td>
                <td><label for="type">Zwemmer</label></td>
                <td><label for="type">Resultaat</label></td>
                <td><label for="type">Actie</label></td>
            </tr>
            
            
<?php
    foreach($wedstrijddeelnames as $wedstrijddeelname)
    {
        echo "<tr><td> " . ucfirst($wedstrijddeelname->resultaat->rondetype->type) . "</td>"; 
        echo "<td> " . $wedstrijddeelname->resultaat->ranking . "</td>";
        echo "<td> " . ucfirst($wedstrijddeelname->persoon->voornaam) . "</td>";
        echo "<td> " . $wedstrijddeelname->resultaat->tijd . "</td>"; 
        echo "<td>" . anchor('trainer/wedstrijdresultaat/resultatenaanpassen/' . $wedstrijddeelname->resultaatId, 'Aanpassen') . "</td></tr>";
    }
?>
</table>