<?php

echo "<h1>Agenda</h1>";



echo '<table class="table">'
        . '<thead><tr><th>Uur</th><th>Maandag</th><th>Dinsdag</th><th>Woensdag</th><th>Donderdag</th><th>Vrijdag</th><th>Zaterdag</th><th>Zondag</th></thead>'
        . '<tbody>';
for ($x = 0; $x <= 21; $x++) {
    echo "<tr><td>" . $x . ":00</td>";
    for ($y = 0; $y <= 6; $y++)
    {
        echo "<td>test</td>";
    }
    echo '</tr>';
}

echo '</tbody></table>';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>



