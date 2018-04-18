<h1 class="">Wedstrijden beheren</h1>
<hr>
<h3>Wedstrijden</h3>

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
          <td>" . anchor('trainer/wedstrijd/aanpassen/'. $wedstrijd->id, 'Aanpassen') . ' ' .
           anchor('trainer/wedstrijd/verwijder/'. $wedstrijd->id, 'Verwijderen'). ' '  .
           anchor('trainer/wedstrijdreeks/toevoegen/'. $wedstrijd->id, 'Reeks toevoegen')."</td>
        </tr>";
    }
    ?>

</table>
<?php echo anchor('trainer/wedstrijd/toevoegen/', 'Voeg een nieuwe wedstrijd toe', 'class="btn btn-primary"'); ?>
