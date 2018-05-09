<form action="<?php echo site_url() ;?>/trainer/startpagina/wijzigingOpslaan" method="post">

<?php
echo '<div>';
    echo form_hidden('id', $nieuwsitem->id);
    echo form_label('Titel:', 'titel');
    echo form_input('titel', $nieuwsitem->titel);
    echo '</div> <div>';
    echo form_label('Tekst:', 'tekst');
    echo form_input('tekst', $nieuwsitem->tekst);
    echo form_label('Foto:', 'foto');
    echo form_input('foto', $nieuwsitem->foto);
    
    echo '</div>';
   ?>
    <button type="submit" value="submit" name="opslaan" class="btn btn-primary">Opslaan</button>
    <?php
    echo anchor('trainer/startpagina/beheren/' ,form_button('annuleren', 'annuleren', 'class="btn btn-primary"')) ;