

<h1 class="">Wedstrijdresultaten beheren</h1>
<hr>
<h3>Afgelopen wedstrijden</h3>
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
        $date_today = date("Y-m-d");
        
        if($wedstrijd->einddatum < $date_today && $wedstrijd->begindatum < $date_today)
        {

        echo
        "<tr>
          <td>" . $wedstrijd->naam . "</td>
          <td>" . $wedstrijd->locatie->naam . "</td>
          <td>" . $wedstrijd->begindatum . "</td>
          <td>" . $wedstrijd->einddatum . "</td>
          <td>" . anchor('trainer/wedstrijdresultaat/resultatenbeheren/'. $wedstrijd->id, 'Resultaten aanpassen') . "</td>
        </tr>";
        
        }
    }
    ?>

</table>
</div>