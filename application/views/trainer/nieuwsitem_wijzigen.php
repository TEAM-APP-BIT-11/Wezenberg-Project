

<?php
echo '<h2>'.$title.'</h2>';
echo form_open_multipart('/trainer/startpagina/wijzigingOpslaan');
echo '<div>';
    echo form_hidden('id', $nieuwsitem->id);
    echo form_label('Titel:', 'titel');
    echo form_input('titel', $nieuwsitem->titel, 'class="form-control"');
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    ?>
     <textarea class="form-control" id="tekst" name="tekst"><?php echo $nieuwsitem->tekst; ?></textarea>    
    <?php
   
    echo form_label('Foto:', 'foto');
    echo form_input('foto', $nieuwsitem->foto, 'class="form-control"');
     
    echo '</div>';
   ?>
     <div>
    <input type="file" name="userfile" size="20" id="userfile" />
     </div>
    <button type="submit" value="submit" name="opslaan" class="btn btn-primary">Opslaan</button>
    <?php
    echo anchor('trainer/startpagina/beheren/' ,form_button('annuleren', 'annuleren', 'class="btn btn-primary"')) ;