<div class="col-md-10 content">

		<h1 class="">Locaties aanpassen</h1>
		<hr>
		<h3>Locatie <?php echo $locatie->naam; ?> aanpassen</h3>

		<?php
    $attributes = array('name' => 'locatie');
    echo form_open('locatie/pasAan', $attributes);

    echo form_labelpro('Naam', 'naam');
    echo form_input(array('name' => 'naam',
        'id' => 'naam',
        'value' => $locatie->naam,
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    echo form_labelpro('Straat', 'straat');
    echo form_input(array('name' => 'straat',
        'id' => 'straat',
        'value' => $locatie->straat,
        'class' => 'form-control',
        'required' => 'required'));


    echo '</br>';
    echo form_labelpro('Nummer', 'nummer');
    echo form_input(array('name' => 'nummer',
        'id' => 'nummer',
        'value' => $locatie->nr,
        'class' => 'form-control',
        'required' => 'required',
        'type' => 'number',));

    echo '</br>';
    echo form_labelpro('Postcode', 'postcode');
    echo form_input(array('name' => 'postcode',
        'id' => 'postcode',
        'value' => $locatie->postcode,
        'class' => 'form-control',
        'required' => 'required',
        'type' => 'number',));

    echo '</br>';
    echo form_labelpro('Gemeente', 'gemeente');
    echo form_input(array('name' => 'gemeente',
        'id' => 'gemeente',
        'value' => $locatie->gemeente,
        'class' => 'form-control',
        'required' => 'required',));

		echo '</br>';
		echo form_labelpro('Zaal', 'zaal');
		echo form_input(array('name' => 'zaal',
				'id' => 'zaal',
				'value' => $locatie->zaal,
				'class' => 'form-control',
        'required' => 'required',));

		echo '</br>';
		echo form_labelpro('Land', 'land');
		echo form_input(array('name' => 'land',
				'id' => 'land',
				'value' => $locatie->land,
				'class' => 'form-control',
        'required' => 'required',));

		echo '</br>';
		echo form_labelpro('Extra informatie', 'extra informatie');
		echo form_input(array('name' => 'extraInfo',
				'id' => 'extraInfo',
				'value' => $locatie->extraInfo,
				'class' => 'form-control',
        'required' => 'required',));

    echo form_hidden('id', $locatie->id);
    echo form_submit('knop', 'Opslaan', 'class="btn btn-primary"');
    echo form_close();
    ?>

<a href="javascript:history.go(-1);"><button type="button" class="btn btn-secundary">Annuleren</button></a>
<?php echo anchor('trainer/locatie/verwijder/'.$locatie->id, 'Verwijder', 'class="btn btn-danger"');?>

</form>
</div>
