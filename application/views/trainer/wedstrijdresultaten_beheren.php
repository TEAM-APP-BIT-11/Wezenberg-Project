

<h1 class="">Wedstrijdresultaten beheren</h1>
<hr>
<h3>Wedstrijden</h3>

<table class="table">
    <tr>
        <th>Naam</th>
        <th>Actie</th>
    </tr>

    <?php
    foreach ($wedstrijddeelnames as $wedstrijd) {
        echo
        "<tr>
          <td>" . $wedstrijd->wedstrijd . "</td>
          <td>" . anchor('trainer/wedstrijd/aanpassen/'. $wedstrijd->id, 'Aanpassen') . ' ' .
           anchor('trainer/wedstrijd/verwijder/'. $wedstrijd->id, 'Verwijderen')."</td>
        </tr>";
    }
    ?>

</table>
<?php echo anchor('trainer/wedstrijd/toevoegen/', 'Voeg een nieuwe wedstrijd toe', 'class="btn btn-primary"'); ?>
