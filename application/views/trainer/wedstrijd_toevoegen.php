/**
 * @file wedstrijd_toevoegen.php
 *
 * @author Stef Schoeters
 * View waarin je een wedstrijd kan toevoegen
 * - krijgt $afstanden-object binnen
 * - krijgt $slagen-object binnen
 * - krijgt $locaties-object binnen
 * - gebruikt Bootstrap-alerts
 * - gebruikt Bootstrap-modal
 */

<script>
$(document).ready(function () {
  $("#locatieOpslaan").click(function(){
			var naam = $("input[name=locatieNaam]").val();
			if(naam != ""){
				schrijfLocatieWegEnHaalLocatiesOp();
				$("#locatieModal").modal('toggle');
			}else{
				$('#errorZin').text("Gelieven naam in te vullen aub");
			}
  });
});
function schrijfLocatieWegEnHaalLocatiesOp(){
$.ajax({type: "GET",
        url : site_url + "/trainer/Locatie/haalJsonOp_Locaties",
        data:{
            naam: $("input[name=locatieNaam]").val(),
            straat: $("input[name=locatieStraat]").val(),
            nr: $("input[name=locatieHuisnummer]").val(),
            postcode: $("input[name=locatiePostcode]").val(),
            gemeente: $("input[name=locatieGemeente]").val(),
            land: $("input[name=locatieLand]").val(),
            zaal: $("input[name=locatieZaal]").val(),
            extraInfo: $("input[name=locatieBeschrijving]").val(),
        },
        success : function(result){
            try {
                var locaties = jQuery.parseJSON(result);
                var lijst = '#locaties';
                $(lijst).html("");
                for(var i = 0; i < locaties.length; i++){
                    if(locaties[i].naam === $("input[name=locatieNaam]").val()){
                        $(lijst).append('<option value="' + locaties[i].id +'" selected>' + locaties[i].naam + '</option>');
                    } else{
                        $(lijst).append('<option value="' + locaties[i].id +'">' + locaties[i].naam + '</option>');
                    }
                }
            } catch(error){
                alert("--- ERROR IN JSON --" + result);
            }
        },
        error: function(xhr){
            alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
        }
});
}
</script>

<div class="col-md-10 content">

		<h1 class="">Wedstrijden toevoegen</h1>
		<hr>
		<h3>Wedstrijd toevoegen</h3>

		<?php

    if($error != ""){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      '. $error .'
    </div>';
    }

    foreach ($afstanden as $afstand ) {
        $afstandOpties[$afstand->id] = $afstand->afstand;
    }

		foreach ($slagen as $slag ) {
				$slagOpties[$slag->id] = $slag->naam;
		}

		foreach ($locaties as $locatie ) {
				$locatieOpties[$locatie->id] = $locatie->naam;
		}


    $attributes = array('name' => 'wedstrijdToevoegenFormulier');
    echo form_open('trainer/wedstrijd/aanmaken', $attributes);

    echo form_labelpro('Naam', 'naam');
    echo form_input(array('name' => 'naam',
        'id' => 'naam',
        'class' => 'form-control',
        'required' => 'required'));

    echo '</br>';
    echo form_labelpro('Begindatum', 'begindatum');
    echo form_input(array('name' => 'begindatum',
        'id' => 'begindatum',
        'class' => 'form-control',
        'required' => 'required',
				'type' => 'date'));


    echo '</br>';
    echo form_labelpro('Einddatum', 'einddatum');
    echo form_input(array('name' => 'einddatum',
        'id' => 'einddatum',
        'class' => 'form-control',
        'type' => 'date'));

    echo '</br>';
		echo form_labelpro('Locatie', 'locatie');
    echo form_dropdown('locatie', $locatieOpties, '', 'id="locaties"');

		echo '<div id="locatieKnop">
				<button type="button" data-toggle="modal" data-target="#locatieModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
		</div>';

    echo '</br>';
    echo form_labelpro('Extra informatie', 'extra informatie');
    echo form_input(array('name' => 'extraInfo',
        'id' => 'extraInfo',
        'class' => 'form-control'));

	  echo '</br>';
    echo '<div>';
    echo form_submit('knop', 'Toevoegen', 'class="btn btn-primary"');
    echo form_close();

  	echo anchor('trainer/Wedstrijd/beheren', form_button('back', 'Annuleren', 'class="btn btn-warning"')) ;
    echo '</div>';
  	?>

	<div id="locatieModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Locatie toevoegen</h4>
							</div>
							<div class="modal-body">
									<div class="row">
											<p id="errorZin"></p>
											<div class="col-md-6 form-group">
													<label for="locatieNaam" id="naam">Naam</label>
													<input name="locatieNaam" class="form-control" type="text" value="">
											</div>
											<div class="col-md-4 form-group">
													<label for="locatieStraat" id="naam">Straat</label>
													<input name="locatieStraat" class="form-control" type="text" value="">
											</div>
											<div class="col-md-2 form-group">
													<label for="locatieHuisnummer" id="naam">Nummer</label>
													<input name="locatieHuisnummer" class="form-control" type="text" value="">
											</div>
									</div>
									<div class="row">
											<div class="col-md-3">
													<div class="form-group">
															<label for="locatiePostcode" id="naam">Postcode</label>
															<input name="locatiePostcode" class="form-control" type="text" value="">
													</div>
													<div class="form-group">
															<label for="locatieLand" id="naam">Land</label>
															<input name="locatieLand" class="form-control" type="text" value="">
													</div>
											</div>
											<div class="col-md-3">
													<div class="form-group">
															<label for="locatieGemeente" id="naam">Gemeente</label>
															<input name="locatieGemeente" class="form-control" type="text" value="">
													</div>
													<div class="form-group">
															<label for="locatieZaal" id="naam">Zaal</label>
															<input name="locatieZaal" class="form-control" type="text" value="">
													</div>
											</div>
											<div class="col-md-6 form-group">
													<label for="locatieBeschrijving" id="naam">Beschrijving</label>
													<textarea name="locatieBeschrijving" class="form-control" rows="4"></textarea>
											</div>
									</div>
							</div>
							<div class="modal-footer">
									<div class="row">
											<div class="col-md-6">
													<button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
											</div>
											<div id="locatieOpslaan" class="col-md-6">
													<button type="button" class="btn btn-default">Opslaan</button>
											</div>
									</div>
							</div>
					</div>
			</div>
	</div>

</div>
