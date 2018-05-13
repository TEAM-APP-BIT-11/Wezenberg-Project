
<?php if(validation_errors()){?>
<div class="alert alert-warning">
<?php echo validation_errors(); ?>
</div>
<?php }?>
<?php
echo '<h2>'.$title.'</h2>';?>


<?php

echo form_open_multipart('/trainer/startpagina/toevoegenOpslaan');
echo '<div class="form-group">';
    echo form_hidden('id', 0);
    echo form_label('Titel:', 'titel');
    echo form_input('titel', $titel, 'class="form-control" value="<?php echo set_value(titel);?>" ');
    echo '</div> <div class="form-group">';
    echo form_label('Tekst:', 'tekst');
    ?>
     <textarea class="form-control"  id="tekst" name="tekst" ><?php echo $tekst?></textarea>  
    

    <input type="file" name="userfile" size="20" id="userfile"  />
    <?php
   
    
    
    echo '</div>';
   ?>
    <button type="submit" value="submit" name="toevoegen" class="btn btn-primary">Toevoegen</button>