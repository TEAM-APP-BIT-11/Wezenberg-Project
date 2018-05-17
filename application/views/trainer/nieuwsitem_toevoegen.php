
<?php 
/**
 * @file nieuwsitem_toevoegen.php
 * @author Ruben Tuytens
 *
 * View waar een nieuw nieuwsitem kan worden aangemaakt aan de hand van een formulier
 * - krijgt een $fotos-object binnen
 * - gebruikt codeigniter form_validation
 * - gebruikt Bootstrap-alerts
 */



if(validation_errors()){?>
<div class="alert alert-warning">
<?php echo validation_errors(); ?>
</div>
<?php }?>
<?php
echo '<h2>'.$titel.'</h2>';?>


<?php

echo form_open_multipart('/trainer/Startpagina/toevoegenOpslaan');
echo '<div class="form-group">';
    echo form_hidden('id', 0);
    echo form_label('Titel:', 'titel');
    echo form_input('titel',set_value('titel'), 'class="form-control" value="<?php echo set_value(titel);?>" ');
    echo '</div> <div class="form-group">';
    echo form_label('Tekst:', 'tekst');
    ?>
     <textarea class="form-control"  id="tekst" name="tekst" ><?php echo set_value('tekst')?></textarea>  
    <?php
    foreach($fotos as $foto)
        {
        if($foto->foto !== '' || NULL)
        {
              $options[$foto->foto] = $foto->foto;
        }
      
   
  
    }

echo form_label('Foto:', 'foto');

echo form_dropdown('foto', $options, '' ,'class="form-control"');
    ?>

    <input type="file" name="userfile" size="20" id="userfile"  />
    <?php
   
    
    
    echo '</div>';
   ?>
    <button type="submit" value="submit" name="toevoegen" class="btn btn-primary">Toevoegen</button>
    <?php
    echo anchor('trainer/Startpagina/beheren/' ,form_button('annuleren', 'Annuleren', 'class="btn btn-primary"')) ;