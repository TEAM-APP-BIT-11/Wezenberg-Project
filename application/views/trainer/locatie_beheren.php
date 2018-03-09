<h1>Locaties Beheren</h1>
<h3>Lijst van alle locaties</h3>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<table class="table">'
        . '<thead><tr><th>Locatie</th><th>Acties</th></thead>'
        . '<tbody>';
foreach ($locaties as $locatie) {

    //anchor moet nog veranderd worden naar aanpassen ipv beheren
    echo "<tr><td>" . $locatie->naam . "</td><td>" . anchor('trainer/locatie/index', 'Aanpassen/Verwijderen') . "</td></tr>\n";
}
echo '</tbody></table>';

?>


<button>Voeg een nieuwe locatie toe</button>