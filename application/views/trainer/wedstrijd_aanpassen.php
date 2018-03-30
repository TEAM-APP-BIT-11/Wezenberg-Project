<div class="col-md-10 content">

		<h1 class="">Wedstrijden aanpassen</h1>
		<hr>
		<h3>Wedstrijd <?php echo $wedstrijd->naam; ?> aanpassen</h3>

		<?php

		foreach ($locaties as $locatie ) {
				$locatieOpties[$locatie->id] = $locatie->naam;
		}

    $attributes = array('name' => 'wedstrijdAanpassenFormulier');
    echo form_open('trainer/wedstrijd/pasAan', $attributes);

    echo form_labelpro('Naam', 'naam');
    echo form_input(array('name' => 'naam',
        'id' => 'naam',
        'value' => $wedstrijd->naam,
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    echo form_labelpro('Begindatum', 'begindatum');
    echo form_input(array('name' => 'begindatum',
        'id' => 'begindatum',
        'value' => $wedstrijd->begindatum,
        'class' => 'form-control',
        'required' => 'required',
				'type' => 'date',));


    echo '</br>';
    echo form_labelpro('Einddatum', 'einddatum');
    echo form_input(array('name' => 'einddatum',
        'id' => 'einddatum',
        'value' => $wedstrijd->einddatum,
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
        'value' => $wedstrijd->extraInfo,
        'class' => 'form-control',
        'required' => 'required',));

	 echo '<hr>';
	 echo '<h4>Reeksen:</h4>';


			echo '<table class="table">';
	    echo '<tr>';
	    echo     '<th>Datum</th>';
	    echo     '<th>Beginuur</th>';
	    echo     '<th>Einduur</th>';
	    echo     '<th>Actie</th>';
	    echo '</tr>';

	    foreach ($wedstrijdreeksen as $wedstrijdreeks) {
	        echo
					"<tr>
						<td>" . $wedstrijdreeks->datum . "</td>
						<td>" . $wedstrijdreeks->beginuur . "</td>
						<td>" . $wedstrijdreeks->einduur . "</td>
						<td>" . anchor('trainer/wedstrijd/aanpassen/'. $wedstrijdreeks->id, 'Aanpassen') . ' ' .
						anchor('trainer/wedstrijd/verwijder/'. $wedstrijdreeks->id, 'Verwijderen')."</td>
					</tr>";

		  }
			echo '</table>';

// foreach($wedstrijdreeksen as $wedstrijdreeks){
// 	echo '</br>';
// 	echo form_labelpro('Datum', 'datum');
// 	echo form_input(array('name' => 'reeksDatum',
// 			'id' => 'reeksDatum',
// 			'value' => $wedstrijdreeks->datum,
// 			'class' => 'form-control',
// 			'required' => 'required',
// 			'type' => 'date',));
//
// 	echo '</br>';
// 	echo form_labelpro('Beginuur', 'beginuur');
// 	echo form_input(array('name' => 'reeksBeginuur',
// 			'id' => 'reeksBeginuur',
// 			'value' => $wedstrijdreeks->beginuur,
// 			'class' => 'form-control',
// 			'required' => 'required',
// 			'type' => 'date',));
//
// 	echo '</br>';
// 	echo form_labelpro('Einduur', 'einduur');
// 	echo form_input(array('name' => 'reeksEinduur',
// 			'id' => 'reeksEinduur',
// 			'value' => $wedstrijdreeks->einduur,
// 			'class' => 'form-control',
// 			'required' => 'required',));
//
// 	echo '</br>';
// 	echo form_labelpro('Afstand', 'afstand');
// 	echo form_input(array('name' => 'reeksAfstand',
// 			'id' => 'reeksAfstand',
// 			'value' => $wedstrijdreeks->afstand->afstand,
// 			'class' => 'form-control',
// 			'required' => 'required',));
//
// 	echo '</br>';
// 	echo form_labelpro('Slag', 'slag');
// 	echo form_input(array('name' => 'reeksslag',
// 				'id' => 'reeksslag',
// 				'value' => $wedstrijdreeks->slag->naam,
// 				'class' => 'form-control',
// 				'required' => 'required',));
// }


    echo form_hidden('id', $wedstrijd->id);
    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
    echo form_close();
    ?>
		<a href="javascript:history.go(-1);"><button type="button" class="btn btn-secundary">Annuleren</button></a>
	<footer>
	</footer>

</div>
