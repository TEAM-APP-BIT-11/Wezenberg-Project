<div class="col-md-10 content">

		<h1 class="">Wedstrijden reeks aanpassen</h1>
		<hr>
		<h3>Reeks van <?php echo $wedstrijd->naam; ?> aanpassen</h3>

		<?php

    foreach ($afstanden as $afstand ) {
        $afstandOpties[$afstand->id] = $afstand->afstand;
    }

    foreach ($slagen as $slag ) {
        $slagOpties[$slag->id] = $slag->naam;
    }

    $attributes = array('name' => 'wedstrijdReeksAanpassenFormulier');
    echo form_open('trainer/wedstrijdreeks/pasAan', $attributes);

    echo '</br>';
  	echo form_labelpro('Datum', 'datum');
  	echo form_input(array('name' => 'reeksDatum',
  			'id' => 'reeksDatum',
        'value' => $wedstrijdreeks->datum,
  			'class' => 'form-control',
  			'required' => 'required',
        'type' => 'date',));
  	echo '</br>';
  	echo form_labelpro('Beginuur', 'beginuur');
  	echo form_input(array('name' => 'reeksBeginuur',
  			'id' => 'reeksBeginuur',
        'value' => $wedstrijdreeks->beginuur,
  			'class' => 'form-control',
  			'required' => 'required',));
  	echo '</br>';
  	echo form_labelpro('Einduur', 'einduur');
  	echo form_input(array('name' => 'reeksEinduur',
  			'id' => 'reeksEinduur',
        'value' => $wedstrijdreeks->einduur,
  			'class' => 'form-control',
  			'required' => 'required',));
  	echo '</br>';
  	echo form_labelpro('Afstand', 'afstand');
  	echo form_dropdown('afstand', $afstandOpties);
  	echo '</br>';
  	echo form_labelpro('Slag', 'slag');
  	echo form_dropdown('slag', $slagOpties);
  	echo '</br>';

  echo form_hidden('id', $wedstrijdreeks->id);
  echo form_hidden('wedstrijdId', $wedstrijdreeks->wedstrijdId);
  echo form_submit('knop', 'Toevoegen', 'class="btn btn-primary"');
  echo form_close();

	echo anchor('trainer/Wedstrijd/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;
	?>
</div>