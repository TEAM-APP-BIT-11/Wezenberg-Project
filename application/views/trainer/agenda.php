<?php
/**
 * Created by PhpStorm.
 * User: Neil
 * Date: 4/05/2018
 * Time: 14:23
 */

$personen = "";

foreach ($zwemmers as $zwemmer) {
    $personen .= '<div class="panel panel-default col-md-3">
  <div class="panel-heading">Agenda van ' . $zwemmer->voornaam . '</div>
  <div class="panel-body">' . anchor('zwemmer/Agenda/raadplegen/' . $zwemmer->id, 'Bekijk agenda', 'class="btn btn-primary"') . '</div></div><div class="col-md-1"></div>';
}

?>

    <h2>Bekijk de agenda van de zwemmers</h2>


<?php echo $personen; ?>