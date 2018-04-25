<div class="col-md-10 content">

    <h1 class="">Wedstrijden aanpassen</h1>
    <hr>
    <h3>Wedstrijd <?php echo $wedstrijd->naam; ?> aanpassen</h3>

    <?php
    foreach ($locaties as $locatie) {
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
    echo '<th>Datum</th>';
    echo '<th>Beginuur</th>';
    echo '<th>Einduur</th>';
    echo '<th>Actie</th>';
    echo '</tr>';

    foreach ($wedstrijdreeksen as $wedstrijdreeks) {
        echo
        "<tr>
						<td>" . $wedstrijdreeks->datum . "</td>
						<td>" . $wedstrijdreeks->beginuur . "</td>
						<td>" . $wedstrijdreeks->einduur . "</td>
						<td>" . anchor('trainer/wedstrijdreeks/aanpassen/' . $wedstrijdreeks->id, 'Aanpassen') . ' ' .
        anchor('trainer/wedstrijdreeks/verwijder/' . $wedstrijdreeks->id, 'Verwijderen') . "</td>
					</tr>";
    }
    echo '</table>';

    echo form_hidden('id', $wedstrijd->id);
    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
    echo form_close();
    ?>
    <?php echo anchor('trainer/Wedstrijd/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;?>
    <footer>
    </footer>

</div>
