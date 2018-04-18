<h2>Contact</h2>

<p>Op deze pagina kan u een bericht intypen.</p>


<?php
$attributes = array('name' => 'contact');
echo form_open('bezoeker/Contact/verwerk', $attributes);

echo form_labelpro('E-mailadres', 'email');
echo form_input(array('name' => 'email',
    'id' => 'email',
    'type' => 'email',
    'class' => 'form-control',
    'required' => 'required'));

echo '</br>';
echo form_labelpro('Bericht:', 'bericht');
echo form_textarea(array('name' => 'bericht',
    'id' => 'bericht',
    'class' => 'form-control',
    'required' => 'required',));

echo form_hidden('emailzwemmer', $email);
echo form_hidden('id', $id);
echo form_submit('knop', 'Verzend', 'class="btn btn-primary"');
echo form_reset('knop', 'Reset', 'class="btn btn-default"');
echo form_close();

?>