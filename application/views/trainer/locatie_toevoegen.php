<div class="col-md-10 content">

		<h1 class="">Locaties beheren</h1>
		<hr>
		<h3>Locatie toevoegen</h3>

		<div class="col-md-10 content">

				<?php
		    $attributes = array('name' => 'locatie');
		    echo form_open('locatie/pasAan', $attributes);

		    echo form_labelpro('Naam', 'naam');
		    echo form_input(array('name' => 'naam',
		        'id' => 'naam',
		        'class' => 'form-control',
		        'required' => 'required'));

		    echo '</br>';
		    echo form_labelpro('Straat', 'straat');
		    echo form_input(array('name' => 'straat',
		        'id' => 'straat',
		        'class' => 'form-control',
		        'required' => 'required'));


		    echo '</br>';
		    echo form_labelpro('Nummer', 'nummer');
		    echo form_input(array('name' => 'nummer',
		        'id' => 'nummer',
		        'class' => 'form-control',
		        'required' => 'required',
		        'type' => 'number',));

		    echo '</br>';
		    echo form_labelpro('Postcode', 'postcode');
		    echo form_input(array('name' => 'postcode',
		        'id' => 'postcode',
		        'class' => 'form-control',
		        'required' => 'required',
		        'type' => 'number',));

		    echo '</br>';
		    echo form_labelpro('Gemeente', 'gemeente');
		    echo form_input(array('name' => 'gemeente',
		        'id' => 'gemeente',
		        'class' => 'form-control',
		        'required' => 'required',));

				echo '</br>';
				echo form_labelpro('Zaal', 'zaal');
				echo form_input(array('name' => 'zaal',
						'id' => 'zaal',
						'class' => 'form-control',
		        'required' => 'required',));

				echo '</br>';
				echo form_labelpro('Land', 'land');
				echo form_input(array('name' => 'land',
						'id' => 'land',
						'class' => 'form-control',
		        'required' => 'required',));

				echo '</br>';
				echo form_labelpro('Extra informatie', 'extra informatie');
				echo form_input(array('name' => 'extraInfo',
						'id' => 'extraInfo',
						'class' => 'form-control',
		        'required' => 'required',));

		    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
		    echo form_close();
		    ?>
		</form>
		<a href="javascript:history.go(-1);"><button type="button" class="btn btn-secundary">Annuleren</button></a>
		</div>

</form>
</div>
