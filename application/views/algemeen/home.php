<div class="col-md-12">
  <!-- Jumbotron -->
  <div class="text-center">
    <div class="jumbotron">
      <h1>Trainingscentrum Wezenberg</h1>
      <p class="lead">Welkom op de webapplicatie van het trainingscentrum in Wezenberg. Deze applicatie is ter illustratie!</p>
      <?php echo anchor('bezoeker/Contact/trainers', 'Contacteer Wezenberg', 'class="btn btn-primary"'); ?>
    </div>

      
      <?php
         echo  '<div class="row">';
      foreach($nieuwsitems as $nieuws)
      {
          echo '<div class="col-lg-4"><h3>'.$nieuws->titel.'</h3><p>'.$nieuws->tekst.'</p>'
                  . toonAfbeelding('nieuwsitems/' . $nieuws->foto . ' ', 'width="250px" height="250px"').'</div>';
      }
      echo '</div>';
      
      ?>
    
  </div>

  
  
  <div class="row">
    <h2 class="text-center">Kalender</h2>
    <div class="col-lg-8 col-lg-push-2">
        
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Evenement</th>
            <th>Datum en uur</th>
            <th>Locatie</th>
          </tr>
        </thead>
        <tbody>
            <?php
        
            foreach($kalender as $wedstrijd){
                echo '<tr><td>'.$wedstrijd->naam.'</td><td>'. $wedstrijd->begindatum . '</td><td>'. $wedstrijd->locatie->naam.'</td>.</tr>';
            }
            ?>
          
        </tbody>
      </table>
        
    </div>
  </div>
</div>
