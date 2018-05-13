<?php
echo '<h2>'.$title.'</h2>';?>


<?php

echo form_open_multipart('/trainer/startpagina/toevoegenOpslaan');
echo '<div>';
    echo form_hidden('id', 0);
    echo form_label('Titel:', 'titel');
    echo form_input('titel', '', 'class="form-control" required');
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    ?>
     <textarea class="form-control"  id="tekst" name="tekst" required></textarea>  
    

    <input type="file" name="userfile" size="20" id="userfile"  />
    <?php
   
    
    
    echo '</div>';
   ?>
    <button type="submit" value="submit" name="toevoegen" class="btn btn-primary">Toevoegen</button>