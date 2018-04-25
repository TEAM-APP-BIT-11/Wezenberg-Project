<h1 class="">Supplementen beheren</h1>
<hr>
<h3>Supplementen</h3>

<table class="table">
    <tr>
        <th>Naam</th>
        <th>Doelstelling</th>
        <th>Actie</th>
    </tr>

    <?php
    foreach ($voedingssupplementen as $voedingssupplement) {
        echo
        "<tr>
          <td>". $voedingssupplement->naam . "</td>
          <td>". $voedingssupplement->doelstelling->doelstelling . "</td>
          <td>" . anchor('trainer/supplement/aanpassenBis/' . $voedingssupplement->id, 'Aanpassen') . ' '  .
          anchor('trainer/supplement/verwijderBis/' . $voedingssupplement->id, 'Verwijderen') . "</td>
        </tr>";
    }
    ?>
</table>

<?php echo anchor('trainer/Supplement/toevoegenBis/', 'Voeg een nieuw supplement toe', 'class="btn btn-primary"'); ?>
