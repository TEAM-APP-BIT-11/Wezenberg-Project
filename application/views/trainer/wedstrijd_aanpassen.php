<nav class="navbar navbar-default navbar-static-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">
				Wezenberg
			</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Trainer
						<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
<div class="container-fluid main-container">
	<div class="col-md-2 sidebar">
		<ul class="nav nav-pills nav-stacked">
			<li><a href="#">Home</a></li>
			<li class="active"><a href="#">Wedstrijd beheren</a></li>
			<li><a href="#">Wedstrijd aanvragen</a></li>
			<li><a href="#">Locatie beheren</a></li>
			<li><a href="#">Resultaten bekijken</a></li>
			<li><a href="#">Resultaten beheren</a></li>
			<li><a href="#">Gebruikers</a></li>
			<li><a href="#">Schema supplementen</a></li>
			<li><a href="#">Supplementen beheren</a></li>
			<li><a href="#">Homepagina beheren</a></li>
		</ul>
	</div>
	<div class="col-md-10 content">

		<h1 class="">Wedstrijd x</h1>
		<hr>
		<h3>Vul de onderstaande velden in om een nieuwe wedstrijd aan te maken.</h3>

		<form>
			<div class="form-group">
				<label for="name">Naam:</label>
				<input type="text" class="form-control" id="name" placeholder="Naam">
			</div>

			<div class="form-group">
				<label for="begindatum">Begindatum:</label>
				<input type="text" class="form-control" id="begindatum" placeholder="Begindatum">
			</div>

			<div class="form-group">
				<label for="einddatum">Einddatum:</label>
				<input type="text" class="form-control" id="einddatum" placeholder="Einddatum">
			</div>

			<div class="form-group">
				<label for="locatie">Locatie:</label>
				<input type="text" class="form-control" id="locatie" placeholder="Locatie">
			</div>

			<div class="form-group">
				<label for="extrainfo">Extra informatie:</label>
				<textarea id="extrainfo" class="form-control" rows="3" placeholder="Extra informatie"></textarea>
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

		<button type="button" class="btn btn-primary">Annuleren</button>
		<button type="button" class="btn btn-primary">Toevoegen</button>
	</div>

	<footer>
	</footer>

</div>
