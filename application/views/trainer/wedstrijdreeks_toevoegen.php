/**
 * @file wedstrijdreeks_toevoegen.php
 *
 * @author Stef Schoeters
 * View waarin je een wedstrijdreeks kan toevoegen
 * - krijgt $wedstrijdreeks-object binnen
 */
 
<div class="col-md-10 content">

		<h1 class="">Wedstrijden reeks toevoegen</h1>
		<hr>
		<h3>Reeks toevoegen aan <?php echo $wedstrijd->naam; ?></h3>

		<?php

    foreach ($afstanden as $afstand ) {
        $afstandOpties[$afstand->id] = $afstand->afstand;
    }

    foreach ($slagen as $slag ) {
        $slagOpties[$slag->id] = $slag->naam;
    }

    $attributes = array('name' => 'wedstrijdReeksToevoegenFormulier');
    echo form_open('trainer/wedstrijdreeks/aanmaken', $attributes);

    echo '</br>';
  	echo form_labelpro('Datum', 'datum');
  	echo form_input(array('name' => 'reeksDatum',
  			'id' => 'reeksDatum',
  			'class' => 'form-control',
  			'required' => 'required',
        'type' => 'date'));
  	echo '</br>';
  	echo form_labelpro('Beginuur', 'beginuur');
  	echo form_input(array('name' => 'reeksBeginuur',
  			'id' => 'reeksBeginuur',
  			'class' => 'form-control',
  			'required' => 'required',
				'type' => 'time'));

  	echo '</br>';
  	echo form_labelpro('Einduur', 'einduur');
  	echo form_input(array('name' => 'reeksEinduur',
  			'id' => 'reeksEinduur',
  			'class' => 'form-control',
				'type' => 'time'));

  	echo '</br>';
  	echo form_labelpro('Afstand', 'afstand');
  	echo form_dropdown('afstand', $afstandOpties);
  	echo '</br>';
  	echo form_labelpro('Slag', 'slag');
  	echo form_dropdown('slag', $slagOpties);
  	echo '</br>';

	  echo form_hidden('id', $wedstrijd->id);

		echo '</br>';
		echo '<div>';
	  echo form_submit('knop', 'Toevoegen', 'class="btn btn-primary"');
	  echo form_close();

		echo anchor('trainer/Wedstrijd/aanpassen/' . $wedstrijd->id .'', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;
		echo '</div>';
		?>
</div>
