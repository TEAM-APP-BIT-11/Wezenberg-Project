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
        echo
        "<tr>
          <td>" . $wedstrijd->naam . "</td>
          <td>" . $wedstrijd->locatie->naam . "</td>
          <td>" . $wedstrijd->begindatum . "</td>
          <td>" . $wedstrijd->einddatum . "</td>
          <td>" . anchor('trainer/wedstrijd/aanpassen/'. $wedstrijd->id, 'Aanpassen', 'data-toggle="tooltip" data-placement="top" title="Met deze actie kan je de wedstrijd aanpassen"') . ' ' .
           anchor('trainer/wedstrijd/verwijder/'. $wedstrijd->id, 'Verwijderen', 'data-toggle="tooltip" data-placement="top" title="Met deze actie kan je de wedstrijd verwijderen"'). ' '  .
           anchor('trainer/wedstrijdreeks/toevoegen/'. $wedstrijd->id, 'Reeks toevoegen', 'data-toggle="tooltip" data-placement="top" title="Met deze actie kan je een reeks toevoegen aan de wedstrijd"')."</td>
        </tr>";
    }
    ?>

</table>
<?php echo anchor('trainer/wedstrijd/toevoegen/', 'Voeg een nieuwe wedstrijd toe', 'class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Met deze actie kan je een nieuwe wedstrijd toevoegen"'); ?>
