<div class="col-md-10 content">

		<h1 class="">Wedstrijden toevoegen</h1>
		<hr>
		<h3>Wedstrijd toevoegen</h3>

		<?php
    $lijstAfstanden = '';
    $lijstAfstanden[0] = '-- Select --';
		    $lijstAfstanden[1] = '-- test --';
    // foreach ($afstanden as $afstand) {
    //     $lijstAfstanden[$afstand->id] = $afstand->$afstand;
    // }
    $attributes = array('name' => 'wedstrijdToevoegenFormulier');
    echo form_open('wedstrijd/toevoegen', $attributes);

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
    echo form_labelpro('Einddatumm', 'einddatumm');
    echo form_input(array('name' => 'einddatumm',
        'id' => 'einddatumm',
        'class' => 'form-control',
        'required' => 'required',
        'type' => 'date',));

    echo '</br>';
    echo form_labelpro('Locatie', 'locatie');
    echo form_input(array('name' => 'locatie',
        'id' => 'locatie',
        'class' => 'form-control',
        'required' => 'required',
        'type' => 'number',));

    echo '</br>';
    echo form_labelpro('Extra informatie', 'extra informatie');
    echo form_input(array('name' => 'extraInfo',
        'id' => 'extraInfo',
        'class' => 'form-control',
        'required' => 'required',));

	 echo '<hr>';
	 echo '<h4>Reeksen:</h4>';

	echo '</br>';
	echo form_labelpro('Datum', 'datum');
	echo form_input(array('name' => 'reeksDatum',
			'id' => 'reeksDatum',
			'class' => 'form-control',
			'required' => 'required',));

	echo '</br>';
	echo form_labelpro('Beginuur', 'beginuur');
	echo form_input(array('name' => 'reeksBeginuur',
			'id' => 'reeksBeginuur',
			'class' => 'form-control',
			'required' => 'required',));

	echo '</br>';
	echo form_labelpro('Einduur', 'einduur');
	echo form_input(array('name' => 'reeksEinduur',
			'id' => 'reeksEinduur',
			'class' => 'form-control',
			'required' => 'required',));

	echo '</br>';
	// echo form_labelpro('Afstand', 'afstand');
	// echo form_input(array('name' => 'reeksAfstand',
	// 		'id' => 'reeksAfstand',
	// 		'class' => 'form-control',
	// 		'required' => 'required',));
	echo form_dropdown('afstand', $lijstAfstanden, 'id="afstand"');

	echo '</br>';
	echo form_labelpro('Slag', 'slag');
	echo form_input(array('name' => 'reeksslag',
				'id' => 'reeksslag',
				'class' => 'form-control',
				'required' => 'required',));

    echo form_submit('knop', 'Toevoegen', 'class="btn btn-primary"');
    echo form_close();
    ?>
		<a href="javascript:history.go(-1);"><button type="button" class="btn btn-secundary">Annuleren</button></a>
	<footer>
	</footer>

</div>
