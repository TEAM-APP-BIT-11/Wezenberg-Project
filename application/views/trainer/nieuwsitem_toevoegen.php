<?php
echo '<h2>'.$title.'</h2>';?>
<form action="<?php echo site_url() ;?>/trainer/startpagina/toevoegenOpslaan" method="post">

<?php
echo '<div>';
    echo form_hidden('id', 0);
    echo form_label('Titel:', 'titel');
    echo form_input('titel');
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    echo form_input('tekst');
    echo form_label('Foto:', 'foto');
    echo form_input('foto');
    
    echo '</div>';
   ?>
    <button type="submit" value="submit" name="toevoegen" class="btn btn-primary">Toevoegen</button>