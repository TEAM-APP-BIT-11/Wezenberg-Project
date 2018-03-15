<div class="col-md-10 content">

		<h1 class="">Wedstrijden beheren</h1>
		<hr>
		<h3>Wedstrijden</h3>

		<table class="table">
			<tr>
				<th>Naam</th>
				<th>Locatie</th>
				<th>Begindatum</th>
				<th>Einddatum</th>
				<th>Actie</th>
			</tr>

<!-- nog een anchor aan de details
en nog een link maken tussen de locatieId -->

		<?php
		foreach ($wedstrijden as $wedstrijd) {
			echo '<tr><td>'.$wedstrijd->naam.'</td><td>Geel</td><td>'.$wedstrijd->begindatum.'</td><td>'.$wedstrijd->einddatum.'</td><td><a href="">Details</a></td></tr>';
		}
		?>

		</table>
		<button type="button" class="btn btn-primary">Wedstrijd toevoegen</button>
</div>
