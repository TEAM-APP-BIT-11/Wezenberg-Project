<div class="col-md-10 content">

		<h1 class="">Wedstrijd x</h1>
		<hr>
		<h3>Vul de onderstaande velden in om een nieuwe wedstrijd aan te maken.</h3>

		<form>
			<div class="form-group">
				<label for="name">Naam:</label>
				<input type="text" class="form-control" id="name" placeholder="Naam" value="<?php echo $wedstrijd->naam;?>">
			</div>

			<div class="form-group">
				<label for="begindatum">Begindatum:</label>
				<input type="text" class="form-control" id="begindatum" placeholder="Begindatum" value="<?php echo $wedstrijd->begindatum;?>">
			</div>

			<div class="form-group">
				<label for="einddatum">Einddatum:</label>
				<input type="text" class="form-control" id="einddatum" placeholder="Einddatum" value="<?php echo $wedstrijd->einddatum;?>">
			</div>

			<div class="form-group">
				<label for="locatie">Locatie:</label>
				<input type="text" class="form-control" id="locatie" placeholder="Locatie" value="<?php echo $wedstrijd->locatieId;?>">
			</div>

			<div class="form-group">
				<label for="extrainfo">Extra informatie:</label>
				<textarea id="extrainfo" class="form-control" rows="3" placeholder="Extra informatie"><?php echo $wedstrijd->extraInfo;?></textarea>
			</div>
		</form>


		<h4>Reeksen:</h4>
		<h4>Reeks 1:</h4>
		<form class="form-inline">
			<div class="form-group">
				<label for="datum">Datum</label>
				<input type="text" class="form-control" id="datum" placeholder="Datum">
			</div>

			<div class="form-group">
				<label for="beginuur">Beginuur</label>
				<input type="text" class="form-control" id="beginuur" placeholder="Beginuur">
			</div>

			<div class="form-group">
				<label for="afstand">Afstand</label>
				<input type="text" class="form-control" id="afstand" placeholder="Afstand">
			</div>

			<div class="form-group">
				<label for="slag">Slag</label>
				<input type="text" class="form-control" id="slag" placeholder="Slag">
			</div>

		</form>
		<a href="javascript:history.go(-1);"><button type="button" class="btn btn-secundary">Annuleren</button></a>
		<button type="button" class="btn btn-primary">Toevoegen</button>
	</div>

	<footer>
	</footer>

</div>
