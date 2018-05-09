<?php
echo '<h2>'. $title.'</h2>';

?><form action="<?php echo site_url() ;?>/trainer/startpagina/toevoegenHome" method="post">
<?php
echo '<div>';
echo form_label('Groepsfoto:', 'groepsfoto');
echo form_input('groepsfoto');
echo '</div>';
echo form_label('Infoblok:', 'infoblok');
?>
    <textarea  id="infoblok"></textarea>
    <div>
        
    <button name ="opslaan" type="submit" value="submit" class="btn btn-primary">Opslaan</button>
    </div>
</form>
 <hr></hr>
<?php
$teller =1;
echo '<h3>actieve nieuwsblokken</h3>';
echo anchor('trainer/startpagina/toevoegen/', form_button('toevoegen', 'toevoegen', 'class="btn btn-primary"')) ;
foreach($nieuwsitems as $nieuws)
{
    if($nieuws->actief ==1)
    {
     echo '<div>';
     
    echo form_label('Titel:', 'titel');
    echo form_input('titel', $nieuws->titel);
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    echo form_input('tekst', $nieuws->tekst);
    echo toonAfbeelding('nieuwsitems/' . $nieuws->foto . ' ', 'width="250px" height="250px"');
    
    echo '</div>';
    echo anchor('trainer/startpagina/verwijderen/' .$nieuws->id, form_button('verwijderen', 'verwijderen', 'class="btn btn-primary"')) ;
    echo anchor('trainer/startpagina/wijzigen/' .$nieuws->id, form_button('wijzigen', 'wijzigen', 'class="btn btn-primary"')) ;
    echo '<hr></hr>';
    }
    
    
    
  
}
echo '<h3>Gedeactiveerde nieuwsblokken</h3>';
foreach($nieuwsitems as $passief)
{
    if($passief->actief ==0)
    {
       echo '<div>';
     
    echo form_label('Titel:', 'titel');
    echo form_input('titel', $passief->titel);
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    echo form_input('tekst', $passief->tekst);
    echo toonAfbeelding('nieuwsitems/' . $passief->foto . ' ', 'width="250px" height="250px"');
    
    echo '</div>';
    echo anchor('trainer/startpagina/activeren/' .$passief->id, form_button('activeren', 'activeren', 'class="btn btn-primary"')) ;
    
    echo '<hr></hr>'; 
    }
}
?>