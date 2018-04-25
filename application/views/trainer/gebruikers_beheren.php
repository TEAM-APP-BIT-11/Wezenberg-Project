<h1 class="">Gebruikers beheren</h1>
<hr>
<h3>Zwemmers</h3>

<table class="table">
        <?php 
        foreach ($zwemmers as $zwemmer) {

        echo
        "<tr>"
          . "<th>" . $zwemmer->voornaam . " " . $zwemmer->familienaam . "</th>"
          . "<td>" . anchor('trainer/gebruiker/aanpassen/'. $zwemmer->id, 'Gegevens aanpassen', 'class="btn btn-primary"') . "</td>";
          if ($zwemmer->actief == 0)
          {
              echo "<td>" . anchor('trainer/gebruiker/activiteitVeranderen/'. $zwemmer->id, 'Actief maken', 'class="btn btn-primary"') . "</td>";
          }
          else
          {
              echo "<td>" . anchor('trainer/gebruiker/activiteitVeranderen/'. $zwemmer->id, 'Inactief maken', 'class="btn btn-danger"') . "</td>";
          }
        echo "</tr>";
        }
        
        ?>
    
</table>

<table class="table">
    <?php
        echo "<h3>Trainers</h3>";
        foreach ($trainers as $trainer) 
            {
         echo
        "<tr>"
          . "<th>" . $trainer->voornaam . " " . $trainer->familienaam . "</th>"
          . "<td>" . anchor('trainer/gebruiker/aanpassen/'. $trainer->id, 'Gegevens aanpassen', 'class="btn btn-primary"') . "</td>";
          if ($trainer->actief == 0)
          {
              echo "<td>" . anchor('trainer/gebruiker/activiteitVeranderen/'. $trainer->id, 'Actief maken', 'class="btn btn-primary"') . "</td>";
          }
          else
          {
              echo "<td>" . anchor('trainer/gebruiker/activiteitVeranderen/'. $trainer->id, 'Inactief maken', 'class="btn btn-danger"') . "</td>";
          }
        echo "</tr>";
        }
        ?>
</table>

<?php
    echo anchor('trainer/gebruiker/toevoegen', 'Gebruiker toevoegen', 'class="btn btn-primary"');
?>

