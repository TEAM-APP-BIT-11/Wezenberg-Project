

<?php
/**
 * @file nieuwsitem_wijzigen.php
 * @author Ruben Tuytens
 *
 *  View waar een nieuwsitem wordt weergegeven en kan worden aangepast
 * - krijgt een $nieuwsitem-object binnen
 * - krijgt een $fotos-object binnen
 */


echo '<h2>'.$titel.'</h2>';
echo form_open_multipart('/trainer/Startpagina/wijzigingOpslaan');
echo '<div>';
    echo form_hidden('id', $nieuwsitem->id);
    echo form_label('Titel:', 'titel');
    echo form_input('titel', $nieuwsitem->titel, 'class="form-control"');
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    ?>
     <textarea class="form-control" id="tekst" name="tekst"><?php echo $nieuwsitem->tekst; ?></textarea>    
    <?php
   

    
    foreach($fotos as $foto)
        {
        if($foto->foto !== '' || NULL)
        {
              $options[$foto->foto] = $foto->foto;
        }
      
   
  
    }

echo form_label('Foto:', 'foto');

echo form_dropdown('foto', $options, $nieuwsitem->foto ,'class="form-control"');
  
     
    echo '</div>';
   ?>
     <div>
    <input type="file" name="userfile" size="20" id="userfile" />
     </div>
    <button type="submit" value="submit" name="opslaan" class="btn btn-primary">Opslaan</button>
    <?php
    echo anchor('trainer/Startpagina/beheren/' ,form_button('annuleren', 'Annuleren', 'class="btn btn-primary"')) ;