<?php
/**
 * Wordt opgeroepen via ajax. Geeft de supplementen weer voor een bepaalde zwemmer met hun doelstelling.
 */

$lijst = '<table class="table"><tr><th>Supplement</th><th>Aantal</th><th>Doelstelling</th></tr>';
foreach ($innames as $inname) {
    $lijst .= '<tr>';
    $lijst .= '<td>' . $inname->voedingssupplement->naam . '</td>';
    $lijst .= '<td>' . $inname->aantal . '</td>';
    $lijst .= '<td>' . $inname->voedingssupplement->doelstelling->doelstelling . '</td>';
    $lijst .= '</tr>';
}
$lijst .= "</table>";
echo $lijst;
?>