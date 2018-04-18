<div class="col-md-10 content">

		<h1 class="">Wedstrijden toevoegen</h1>
		<hr>
		<h3>Wedstrijd toevoegen</h3>

		<?php

    foreach ($afstanden as $afstand ) {
        $afstandOpties[$afstand->id] = $afstand->afstand;
    }

		foreach ($slagen as $slag ) {
				$slagOpties[$slag->id] = $slag->naam;
		}

		foreach ($locaties as $locatie ) {
				$locatieOpties[$locatie->id] = $locatie->naam;
		}


    $attributes = array('name' => 'wedstrijdToevoegenFormulier');
    echo form_open('trainer/wedstrijd/aanmaken', $attributes);

    echo form_labelpro('Naam', 'naam');
    echo form_input(array('name' => 'naam',
        'id' => 'naam',
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    echo form_labelpro('Begindatum', 'begindatum');
    echo form_input(array('name' => 'begindatum',
        'id' => 'begindatum',
        'class' => 'form-control',
        'required' => 'required',
				'type' => 'date',));


    echo '</br>';
    echo form_labelpro('Einddatum', 'einddatum');
    echo form_input(array('name' => 'einddatum',
        'id' => 'einddatum',
        'class' => 'form-control',
        'required' => 'required',
        'type' => 'date',));

    echo '</br>';
		echo form_labelpro('Locatie', 'locatie');
		echo form_dropdown('locatie', $locatieOpties);

    echo '</br>';
    echo form_labelpro('Extra informatie', 'extra informatie');
    echo form_input(array('name' => 'extraInfo',
        'id' => 'extraInfo',
        'class' => 'form-control',
        'required' => 'required',));

	  echo '</br>';

  echo form_submit('knop', 'Toevoegen', 'class="btn btn-primary"');
  echo form_close();
  ?>
	<?php echo anchor('trainer/Wedstrijd/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;?>
	<footer>
	</footer>

</div>
