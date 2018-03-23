<div class="col-md-10 content">

		<h1 class="">Locaties beheren</h1>
		<hr>
		<h3>Locatie <?php echo $locatie->naam; ?> beheren</h3>
    <h4 class="text-center">Aanpassen</h4>
    <form class="form-horizontal">
<fieldset>

<div class="form-group">
  <label class="col-md-4 control-label" for="locatieNaam">Naam</label>
  <div class="col-md-4">
  <input id="locatieNaam" name="locatieNaam" value="<?php echo $locatie->naam;?>" placeholder="placeholder" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="locatieStraat">Straat</label>
  <div class="col-md-4">
  <input id="locatieStraat" name="locatieStraat" value="<?php echo $locatie->straat;?>" placeholder="placeholder" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="locatieNr">Nummer</label>
  <div class="col-md-4">
  <input id="locatieNr" name="locatieNr" value="<?php echo $locatie->nr;?>" placeholder="placeholder" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="locatiePostcode">Postcode</label>
  <div class="col-md-4">
  <input id="locatiePostcode" name="locatiePostcode" value="<?php echo $locatie->postcode;?>" placeholder="placeholder" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="locatieGemeente">Gemeente</label>
  <div class="col-md-4">
  <input id="locatieGemeente" name="locatieGemeente" value="<?php echo $locatie->gemeente;?>" placeholder="placeholder" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="locatieZaal">Zaal</label>
  <div class="col-md-4">
  <input id="locatieZaal" name="locatieZaal" value="<?php echo $locatie->zaal;?>" placeholder="placeholder" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="locatieLand">Land</label>
  <div class="col-md-4">
  <input id="locatieLand" name="locatieLand" value="<?php echo $locatie->land;?>" placeholder="placeholder" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="locatieExtraInfo">Extra informatie</label>
  <div class="col-md-4">
    <textarea class="form-control" id="locatieExtraInfo" name="textarea"><?php echo $locatie->extraInfo;?></textarea>
  </div>
</div>

</fieldset>

<a href="javascript:history.go(-1);"><button type="button" class="btn btn-secundary">Annuleren</button></a>
<button type="button" class="btn btn-primary">Opslaan</button>

</form>
</div>
