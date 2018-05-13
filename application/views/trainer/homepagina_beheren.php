<script type="text/javascript">
  $(document).ready(function(){
      $('#actief').hide();
      $('#deactief').hide();
      $("#clickme").click(function(){
          $('#actief').toggle();
      })
      $("#gedeactiveerde").click(function(){
          $('#deactief').toggle();
      })
  })
</script>

<?php
echo '<h2>'. $title.'</h2>';

?>
    
<?php
echo form_open_multipart('/trainer/startpagina/homepaginaOpslaan');
echo '<h3>Homepagina beheren</h3>';
echo '<div class="col-md-6">';


echo form_label('Groepsfoto:', 'groepsfoto');
echo form_input('groepsfoto', $homepaginaitem->groepsfoto, 'class="form-control"');
echo '</div>';
?> 
<div class="col-md-5">
    <label for="userfile">Selecteer een bestand:</label>
    <input type="file" name="userfile" size="20" id="userfile" />
</div>
    
<?php

echo '<div class="col-md-12">';
 echo '</br>';
echo form_label('Infoblok:', 'infoblok');
?>

    <textarea  class="form-control" id="infoblok" name="infoblok"><?php echo $homepaginaitem->informatie;?></textarea>
</div>
    <div class="col-md-12">
        </br>
    <button name ="opslaan" type="submit" value="submit" class="btn btn-primary">Opslaan</button>
    </div>

</form>

 <div class="col-md-12">
     </br>
 <button id="clickme" class="btn btn-primary">
  Geactiveerde nieuwsblokken 
</button>
 </div>
<?php
$teller =1;

echo '<div class="col-md-12" name="actief" id="actief">';
echo '<h3>actieve nieuwsblokken</h3>';

echo '<div>';
echo anchor('trainer/startpagina/toevoegen/', form_button('toevoegen', 'Toevoegen', 'class="btn btn-primary"')) ;
echo '</div>';

foreach($nieuwsitems as $nieuws)
{
    if($nieuws->actief ==1)
    {
        echo '<hr></hr>';
     echo '<div>';
      echo '<div  >';
    echo form_label('Titel:', 'titel');
    echo form_input('titel', $nieuws->titel, 'class="form-control" disabled');
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    ?>
     <textarea id="infoblok" class="form-control" disabled><?php echo$nieuws->tekst; ?></textarea>    
     
    <?php
      echo '</div>';
      echo '<div>';
    echo toonAfbeelding('nieuwsitems/' . $nieuws->foto . ' ', 'width="250px" height="250px"');
    
    echo '</div>';
    echo '</div>';
    echo anchor('trainer/startpagina/verwijderen/' .$nieuws->id, form_button('verwijderen', 'Verwijderen', 'class="btn btn-primary"')) ;
    echo anchor('trainer/startpagina/wijzigen/' .$nieuws->id, form_button('wijzigen', 'Wijzigen', 'class="btn btn-primary"')) ;
   
    }
    
    
    
  
}
echo '</div>';

?>
     
     <div class="col-md-12">
     <button id="gedeactiveerde" class="btn btn-primary">Gedeactiveerde nieuwsitems</button>
     </div>
     <?php
echo '<div name="deactief" id="deactief">';
echo '<h3>Gedeactiveerde nieuwsblokken</h3>';
foreach($nieuwsitems as $passief)
{
    if($passief->actief ==0)
    {
       echo '<div>';
     
    echo form_label('Titel:', 'titel');
    echo form_input('titel', $passief->titel, 'class="form-control" disabled');
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    ?>
     <textarea  class="form-control" id="infoblok" disabled><?php echo $passief->tekst; ?></textarea>    
    <?php
    echo toonAfbeelding('nieuwsitems/' . $passief->foto . ' ', 'width="250px" height="250px"');
    
    echo '</div>';
    echo anchor('trainer/startpagina/activeren/' .$passief->id, form_button('activeren', 'Activeren', 'class="btn btn-primary"')) ;
    
    echo '<hr></hr>'; 
    }
}
echo '</div>';
?>