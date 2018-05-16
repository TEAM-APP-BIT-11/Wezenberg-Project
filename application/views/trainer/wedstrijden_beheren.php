<?php
/**
 * @file wedstrijden_beheren.php
 *
 * @author Stef Schoeters
 * View waarin je de bestaande wedstrijds kan beheren (toevoegen, aanpassen en verwijderen)
 * - krijgt $wedstrijden-object binnen
 * - gebruikt Bootstrap-alerts
 */
?>

<script type="text/javascript">
  $(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();

  });
</script>

<h1 class="">Wedstrijden beheren</h1>
<hr>
<h3>Wedstrijden</h3>

<?php
if ($error != null) {
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    '. $error .'
  </div>';
}
?>

<div class="table-responsive">
  <table class="table">
      <tr>
          <th>Naam</th>
          <th>Locatie</th>
          <th>Begindatum</th>
          <th>Einddatum</th>
          <th>Actie</th>
      </tr>

      <?php
      foreach ($wedstrijden as $wedstrijd) {
        if($wedstrijd->begindatum == "0000-00-00"){
          $begindatum = "/";
        }else{
          $begindatum = date('d-m-Y',strtotime($wedstrijd->begindatum));
        }
        if($wedstrijd->einddatum == "0000-00-00"){
          $einddatum = "/";
        }else{
        $einddatum = date('d-m-Y',strtotime($wedstrijd->einddatum));
        }
          echo
          "<tr>
            <td>" . $wedstrijd->naam . "</td>
            <td>" . $wedstrijd->locatie->naam . "</td>
            <td>" . $begindatum . "</td>
            <td>" . $einddatum . "</td>
            <td>" . anchor('trainer/wedstrijd/aanpassen/'. $wedstrijd->id, 'Aanpassen', 'data-toggle="tooltip" data-placement="top" title="Met deze actie kan je de wedstrijd aanpassen"') . ' ' .
             anchor('trainer/wedstrijd/verwijder/'. $wedstrijd->id, 'Verwijderen', 'data-toggle="tooltip" data-placement="top" title="Met deze actie kan je de wedstrijd verwijderen"'). ' '  .
             anchor('trainer/wedstrijdreeks/toevoegen/'. $wedstrijd->id, 'Reeks toevoegen', 'data-toggle="tooltip" data-placement="top" title="Met deze actie kan je een reeks toevoegen aan de wedstrijd"')."</td>
          </tr>";
      }
      ?>

  </table>
</div>
<?php echo anchor('trainer/wedstrijd/toevoegen/nieuw', 'Voeg een nieuwe wedstrijd toe', 'class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Met deze actie kan je een nieuwe wedstrijd toevoegen"'); ?>
