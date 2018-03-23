<div class="col-md-10 content">

		<h1 class="">Locaties beheren</h1>
		<hr>
		<h3>Locaties</h3>

		<table class="table">
			<tr>
				<th>Locatie</th>
				<th>Actie</th>
			</tr>

		<?php
		foreach ($locaties as $locatie) {
			echo "<tr><td>".$locatie->naam."</td><td>".anchor('trainer/locatie/aanpassen/'.$locatie->id, 'Aanpassen/Verwijderen')."</td><td></tr>";
		}
		?>
		</table>

		<?php echo anchor('trainer/locatie/toevoegen/', 'Voeg een nieuwe locatie toe', 'class="btn btn-primary"');?>
</div>
