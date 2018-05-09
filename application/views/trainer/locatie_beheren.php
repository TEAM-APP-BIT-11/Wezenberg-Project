<h1 class="">Locaties beheren</h1>
<hr>
<h3>Locaties</h3>

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
          <th>Locatie</th>
          <th>Actie</th>
      </tr>

      <?php
      foreach ($locaties as $locatie) {
          echo
          "<tr>
            <td>". $locatie->naam . "</td>
            <td>" . anchor('trainer/locatie/aanpassen/' . $locatie->id, 'Aanpassen') . ' '  . anchor('trainer/locatie/verwijder/' . $locatie->id, 'Verwijderen') . "</td>
          </tr>";
      }
      ?>
  </table>
</div>

<?php echo anchor('trainer/locatie/toevoegen/', 'Voeg een nieuwe locatie toe', 'class="btn btn-primary"'); ?>
