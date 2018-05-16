<?php
/**
 * @mainpage Commentaar bij project Wezenberg App - Team11
 * 
 * # Wat?
 * Je vindt hier onze Doxygen-commentaar bij het PHP-project <b>Wezenberg App - Team11</b>
 */
?>


<div class="col-md-12">
  <!-- Jumbotron -->
  <div class="text-center">
    <div class="jumbotron col-md-12">
      <h1>Trainingscentrum Wezenberg</h1>
      <p class="lead">Welkom op de webapplicatie van het trainingscentrum in Wezenberg. Deze applicatie is ter illustratie!</p>
      <p> <?php echo $homepagina->informatie;?></p>
      <?php echo anchor('bezoeker/Contact/trainers', 'Contacteer Wezenberg', 'class="btn btn-primary"'); 
      echo '<div class="col-md-12"></br>';
        echo toonAfbeelding('nieuwsitems/' . $homepagina->groepsfoto ).'</div>';?>
    </div>

      
      <?php
      
      echo '<div class="col-md-12" >';
       $teller=0;
      foreach($nieuwsitems as $nieuws)
      {
          if($teller == 3)
          {
              $teller =0;
              echo '</div><div class="col-md-12" style="padding: 5px;">';
          }
          else
          {
             if($nieuws->foto != NULL)
          {
              echo '<div class="col-md-4 thumbnail" ><h3>'.$nieuws->titel.'</h3><p>'.$nieuws->tekst.'</p>'
                  . toonAfbeelding('nieuwsitems/' . $nieuws->foto . ' ', 'width="250px" height="250px"').'</div>';
              $teller++;
          }
          else
          {
              echo '<div class="col-md-4 thumbnail"><td><h3>'.$nieuws->titel.'</h3><p>'.$nieuws->tekst.'</p>'
                  .'</td></div>';
              $teller++;
          } 
          }
          
         
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
