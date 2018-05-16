/**
 * @file locatie_toevoegen.php
 *
 * @author Stef Schoeters
 * View waarin je een locatie kan toevoegen
 */

<div class="col-md-10 content">

		<h1 class="">Locaties beheren</h1>
		<hr>
		<h3>Locatie toevoegen</h3>
				<?php
		    $attributes = array('name' => 'locatieToevoegenFormulier');
		    echo form_open('trainer/locatie/voegToe', $attributes);

		    echo form_labelpro('Naam', 'naam');
		    echo form_input(array('name' => 'naam',
		        'id' => 'naam',
		        'class' => 'form-control',
		        'required' => 'required'));

		    echo '</br>';
		    echo form_labelpro('Straat', 'straat');
		    echo form_input(array('name' => 'straat',
		        'id' => 'straat',
		        'class' => 'form-control'));


		    echo '</br>';
		    echo form_labelpro('Nummer', 'nummer');
		    echo form_input(array('name' => 'nr',
		        'id' => 'nr',
		        'class' => 'form-control',
		        'type' => 'number',));

		    echo '</br>';
		    echo form_labelpro('Postcode', 'postcode');
		    echo form_input(array('name' => 'postcode',
		        'id' => 'postcode',
		        'class' => 'form-control',
		        'type' => 'number',));

		    echo '</br>';
		    echo form_labelpro('Gemeente', 'gemeente');
		    echo form_input(array('name' => 'gemeente',
		        'id' => 'gemeente',
		        'class' => 'form-control'));

				echo '</br>';
				echo form_labelpro('Zaal', 'zaal');
				echo form_input(array('name' => 'zaal',
						'id' => 'zaal',
						'class' => 'form-control'));

				echo '</br>';
				echo form_labelpro('Land', 'land');
				echo form_input(array('name' => 'land',
						'id' => 'land',
						'class' => 'form-control'));

				echo '</br>';
				echo form_labelpro('Extra informatie', 'extra informatie');
				echo form_input(array('name' => 'extraInfo',
						'id' => 'extraInfo',
						'class' => 'form-control'));

				echo '<div>';
				echo '</br>';
		    echo form_submit('knop', 'Toevoegen', 'class="btn btn-primary"');
		    echo form_close();

				echo anchor('trainer/Locatie/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;
				echo '</div>';
				?>
</div>
