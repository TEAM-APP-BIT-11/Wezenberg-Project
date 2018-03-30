<?php
/**
 * Created by PhpStorm.
 * User: Neil
 * Date: 30/03/2018
 * Time: 14:25
 */
var_dump($innames);

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