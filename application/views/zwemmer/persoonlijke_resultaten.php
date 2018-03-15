<div class="col-md-10 content">

		<h1 class="">Mijn wedstrijd resultaten</h1>
		<hr>

    <select class="form-control">
      <option>Wedstrijd x</option>
      <option>Wedstrijd y</option>
      <option>Wedstrijd z</option>
    </select>

		<h3>Resultaat: x</h3>

		<table class="table">
			<tr>
				<th>Tijd</th>
				<th>Ranking</th>
			</tr>

<!-- Nog een onderverdeling in ronde types -->

		<?php
		foreach ($resultaten as $resultaat) {
			echo "<tr><td>".$resultaat->tijd."</td><td>".$resultaat->ranking."</td><td></tr>";
		}
		?>

		</table>

</div>
