<div class="table-responsive">
  <table class="table">
              <tr class="active">
                  <td><label for="type">Slag</label></td>
                  <td><label for="type">Ronde</label></td>
                  <td><label for="type">Tijd</label></td>
                  <td><label for="type">Resultaat</label></td>
              </tr>


  <?php

  $slag = [];
  $tellerReeks = 0;
  $tellerDeelname = 0;
  if (!empty($wedstrijdreeksen)) {
      foreach ($wedstrijdreeksen as $wedstrijdreeks) {
          $slag[$tellerReeks] = $wedstrijdreeks->slag->naam;
          $tellerReeks++;
      }
  }

  if (!empty($wedstrijddeelnames)) {
      foreach ($wedstrijddeelnames as $wedstrijddeelname) {
          if (!empty($slag[$tellerDeelname]) & !empty($wedstrijddeelname->resultaat->rondetype->type) & !empty($wedstrijddeelname->resultaat->tijd)) {
              echo "<tr><td> " . $slag[$tellerDeelname] . "</td>";
              echo "<td> " . $wedstrijddeelname->resultaat->rondetype->type . "</td>";
              echo "<td> " . $wedstrijddeelname->resultaat->tijd . "</td>";
              echo "<td> " . $wedstrijddeelname->resultaat->ranking . "</td></tr>";
              $tellerDeelname++;
          }
      }
  }
  ?>
  </table>
</div>
