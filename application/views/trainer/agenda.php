<?php
/**
 * Toont de zwemmers van de applicatie met een link naar hun agenda.
 * @author Neil Van den Broeck
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