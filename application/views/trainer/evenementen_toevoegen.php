<?php 
$dagen = array('Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag');
$nummerdagen = array('1', '2', '3', '4', '5', '6', '7');
?>

<script type="text/javascript">
    $(document).ready(function(){
        //DateTimePicker
        $('#datetimepickerBegindatum, #datetimepickerEinddatum').datetimepicker({
            locale: 'nl-be',
            format: 'L'
        });
        $('#datetimepickerBeginuur, #datetimepickerEinduur').datetimepicker({
            locale: 'nl-be',
            format: 'LT'
        });
        //Submit Form
        $("#opslaan").click(function(){
            var deelnemendeZwemmers = '';
            $("#deelnemendeZwemmers option").each(function(){
                deelnemendeZwemmers += $(this).val() + ',';
            });
            $("#zwemmers").val(deelnemendeZwemmers);
            $("#type, #hoeveelheid, #einddatum").attr('disabled', false);
            $("#nieuweEvenementenForm").submit();
        });
        //Change Form
        $("#type, #hoeveelheid").on('change', function(){
            var type = $("#type option:selected").text();
            var hoeveelheid = $('#hoeveelheid').val();
            if(type === 'Stage'){
                $("#titel").html('Stage toevoegen');
                $("#hoeveelheid").val('enkel');
                $("#hoeveelheid").prop('disabled', true);
                $("#begindatum").html('Begindatum *');
                $("#einddatum").prop('disabled', false);
                $("#dagen").hide();
            } else{
                if(type === 'Training' && hoeveelheid === 'enkel'){
                    $("#titel").html('Training toevoegen');
                    $("#hoeveelheid").prop('disabled', false);
                }
                if(type === 'Training' && hoeveelheid === 'meerdere'){
                    $("#titel").html('Trainingen toevoegen');
                }
                if(type === 'Medische test'){
                    $("#titel").html('Medische test toevoegen');
                    $("#hoeveelheid").val('enkel');
                    hoeveelheid = 'enkel';
                    $("#hoeveelheid").prop('disabled', true);
                }
                if(type === 'Overige' && hoeveelheid === 'enkel'){
                    $("#titel").html('Evenement toevoegen');
                    $("#hoeveelheid").prop('disabled', false);
                }
                if(type === 'Overige' && hoeveelheid === 'meerdere'){
                    $("#titel").html('Evenementen toevoegen');
                }
                if(hoeveelheid === 'enkel'){
                    $("#begindatum").html('Datum *');
                    $("#einddatum label").html('Einddatum');
                    $("#einddatum input").prop('disabled', true);
                    $("#einddatum input").prop('required', false);
                    $("#dagen").hide();
                } else{
                    $("#hoeveelheid").prop('disabled', false);
                    $("#begindatum").html('Begindatum *');
                    $("#einddatum label").html('Einddatum *');
                    $("#einddatum input").prop('disabled', false);
                    $("#einddatum input").prop('required', true);
                    $("#dagen").show();
                }
            }     
        });
        //Select Swimmers
        $("#zwemmerKnoppen").click(function(e){
            if($(e.target).attr('class').substr(0, 18) === 'voegZwemmerToeKnop'){
                var geselecteerdeZwemmerId = $("#alleZwemmers").val();
                var geselecteerdeZwemmerNaam = $("#alleZwemmers option:selected").text();
                if(geselecteerdeZwemmerId !== null){ 
                    $("#alleZwemmers option").each(function(){
                        if($(this).val() === geselecteerdeZwemmerId){
                            $(this).remove();
                        }
                    });
                    $("#deelnemendeZwemmers").append(new Option(geselecteerdeZwemmerNaam, geselecteerdeZwemmerId));
                }
            }
            if($(e.target).attr('class').substr(0, 18) === 'haalZwemmerWegKnop'){
                var geselecteerdeZwemmerId = $("#deelnemendeZwemmers").val();
                var geselecteerdeZwemmerNaam = $("#deelnemendeZwemmers option:selected").text();
                if(geselecteerdeZwemmerId !== null){ 
                    $("#deelnemendeZwemmers option").each(function(){
                        if($(this).val() === geselecteerdeZwemmerId){
                            $(this).remove();
                        }
                    });
                    $("#alleZwemmers").append(new Option(geselecteerdeZwemmerNaam, geselecteerdeZwemmerId));
                }
            }
        });
        //Locatie toevoegen
        $("#locatieOpslaan button").click(function(){
            schrijfLocatieWegEnHaalLocatiesOp();
            $("#locatieModal").modal('toggle');
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
                        var lijst = '#locatie';
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
    });
</script>

<style>
    #dagen{
        <?php if(!$isReeks){echo 'display: none;';}?>
    }
    #dagenLabel{
        margin-left: 15px;
    }
    textarea{
        resize: vertical;
    }
    #zwemmerKnoppen{
        margin-top: 25px;
    }
    #zwemmerKnoppen div:first-child{
        margin-bottom: 10px;
    }
    #zwemmerKnoppen button{
        width: 100%;
        height: 3%;
    }
    #formControls div:first-child{
        text-align: right;
    }
    #locatieKnop button{
        height: 4%;
        margin-top: 26px;
    }
    .modal-footer{
        text-align: center;
    }
</style>

<h1 id="titel"><?php echo ucfirst($evenementtype->type);?> toevoegen</h1>
<hr>
<form id="nieuweEvenementenForm" method="post" action="<?php echo $this->config->site_url() . '/trainer/Evenement/voegNieuweEvenementenToe';?>" data-toggle="validator">
    <input id="zwemmers" name="zwemmers" value="" hidden>
    <input id="nieuw" name="nieuw" value="<?php echo ($isNieuw)?'true':'false';?>" hidden>
    <?php
        if(!$isNieuw && $isReeks){
            echo '<input id="ids" name="ids" value="' . $ids . '" hidden>';
        }
        if(!$isNieuw && !$isReeks){
            echo '<input id="ids" name="id" value="' . $id . '" hidden>';
        }
        if(!$isNieuw && ($evenementtype->id != 1 || $evenementtype->id != 4)){
            echo '<input id="evenementreeksId" name="evenementreeksId" value="' . $evenement->evenementReeksId . '" hidden>';
        }
    ?>
    <div class="row">
        <div class="col-md-2 form-group">
            <label for="type">Type Evenement *</label>
            <select name="type" id="type" class="form-control" <?php if(!$isNieuw){echo 'disabled';}?> required>
                <?php
                echo '<option value="' . $evenementtype->id . '" selected>' . ucfirst($evenementtype->type) . '</option>';
                foreach($types as $evenementType){
                    if($evenementType->id !== $evenementtype->id){
                        echo '<option value="' . $evenementType->id . '">' . ucfirst($evenementType->type) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div id="hoeveelheidskolom" class="col-md-2 form-group">
            <label for="hoeveelheid">Hoeveelheid *</label>
            <select name="hoeveelheid" id="hoeveelheid" class="form-control" <?php if($evenementtype->type == 'stage' || $evenementtype->type == 'medische test' || !$isNieuw){echo ' disabled';}?> required>
                <?php
                if(!$isNieuw && $isReeks){
                    echo '<option value="meerdere" selected>Reeks</option>';
                } else{
                    echo '<option value="enkel" selected>Enkel</option>';
                    echo  nl2br ("\n");
                    echo '<option value="meerdere">Reeks</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="naam" id="naam">Evenementnaam *</label>
            <input name="naam" class="form-control" type="text" value="<?php if(!$isNieuw){echo $evenement->naam;}?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 form-group">
            <label for="begindatum" id="begindatum"><?php if(!$isNieuw && $isReeks){echo 'Begindatum';}else{echo 'Datum';}?> *</label>
            <div class='input-group date' id='datetimepickerBegindatum'>
                <input name="begindatum" type='text' class="form-control" <?php if(!$isNieuw){echo 'value="' . zetOmNaarDDMMYYYY($evenement->begindatum) . '"';}?> required/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="col-md-2 form-group meerdere" id="einddatum">
            <label for="einddatum">Einddatum</label>
            <div class='input-group date' id='datetimepickerEinddatum'>
                <input name="einddatum" type='text' class="form-control"
                    <?php
                    if(!$isNieuw && $evenement->einddatum != ""){
                        echo 'value="' . zetOmNaarDDMMYYYY($evenement->einddatum) . '"';
                    }
                    if(in_array($evenementtype->type, ['training','medische test','overige']) && !$isReeks){
                        echo ' disabled';
                    }
                    ?>/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="col-md-2 form-group">
            <label for="beginuur">Beginuur *</label>
            <div class='input-group date' id='datetimepickerBeginuur'>
                <input name="beginuur" type='text' class="form-control" <?php if(!$isNieuw){echo 'value="' . $evenement->beginuur . '"';}?> required/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <div class="col-md-2 form-group">
            <label for="einduur">Einduur</label>
            <div class='input-group date' id='datetimepickerEinduur'>
                <input name="einduur" type='text' class="form-control" <?php if(!$isNieuw && $evenement->einduur != ""){echo 'value="' . $evenement->einduur . '"';}?>/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
    </div>
    <div id="dagen" class="row form-group">
        <label id="dagenLabel">Gaat door op *</label>
        <div class="col-md-12">
            <?php
            for($i = 0; $i < count($nummerdagen); $i++){
                if(!$isNieuw && $isReeks && in_array($nummerdagen[$i], $days)){
                    echo '<label class="checkbox-inline"><input type="checkbox" name="check_list[]" value="' . ($i+1) . '" checked>' . $dagen[$i] . '</label>';
                } else{
                    echo '<label class="checkbox-inline"><input type="checkbox" name="check_list[]" value="' . ($i+1) . '">' . $dagen[$i] . '</label>';
                }
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="beschrijving">Beschrijving</label>
            <textarea name="beschrijving" class="form-control" rows="3"><?php if(!$isNieuw && $evenement->extraInfo != ""){echo $evenement->extraInfo;}?></textarea>
        </div>
        <div class="col-md-3 form-group">
            <label for="locatie">Locatie *</label>
            <select id="locatie" name="locatie" class="form-control" required>
                <?php
                if($isNieuw){
                    echo '<option value="" disabled selected>Kies een locatie</option>';
                } else{
                    echo '<option value="' . $evenement->locatieId . '" selected>' . $locaties[$id=$evenement->locatieId]->naam . '</option>';
                    unset($locaties[$evenement->locatieId]);
                }
                foreach($locaties as $locatie){
                    echo '<option value="' . $locatie->id . '">' . $locatie->naam . '</option>';
                }
                ?>    
            </select>
        </div>
        <div id="locatieKnop" class="col-md-1 form-group">
            <button class="voegZwemmerToeKnop" type="button" data-toggle="modal" data-target="#locatieModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 form-group">
            <label for="alleZwemmers">Alle zwemmers</label>
            <select name="alleZwemmers" id="alleZwemmers" class="form-control" size="<?php echo count($zwemmers);?>">
                <?php
                foreach($zwemmers as $zwemmer){
                    if(!in_array($zwemmer, $deelnemendeZwemmers)){
                        echo '<option value="' . $zwemmer->id . '">' . ucfirst($zwemmer->voornaam) . ' ' . ucfirst($zwemmer->familienaam) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div id="zwemmerKnoppen" class="col-md-2 form-group">
            <div class="voegZwemmerToeKnop"><button class="voegZwemmerToeKnop" type="button"><span class="voegZwemmerToeKnop glyphicon glyphicon-arrow-right" aria-hidden="true"></span></button></div>
            <div class="haalZwemmerWegKnop"><button class="haalZwemmerWegKnop" type="button"><span class="haalZwemmerWegKnop glyphicon glyphicon-arrow-left" aria-hidden="true"></span></button></div>
        </div>
        <div class="col-md-3 form-group">
            <label for="deelnemendeZwemmers">Deelnemende zwemmers</label>
            <select name="deelnemendeZwemmers" id="deelnemendeZwemmers" class="form-control" size="<?php echo count($zwemmers);?>">
                <?php
                if(!$isNieuw){
                    foreach($deelnemendeZwemmers as $deelnemendeZwemmer){
                        echo '<option value="' . $deelnemendeZwemmer->id . '">' . ucfirst($deelnemendeZwemmer->voornaam) . ' ' . ucfirst($deelnemendeZwemmer->familienaam) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
</form>
<div id="formControls" class="row">
    <div class="col-md-3"><?php echo anchor($this->config->site_url() . '/trainer/Evenement/beheren', 'Annuleren', 'class="btn btn-primary btn-lg"');?></div>
    <div class="col-md-2"></div>
    <div class="col-md-3"><button id="opslaan" class="btn btn-primary btn-lg">Opslaan</button></div>
</div>

<div id="locatieModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Locatie toevoegen</h4>
            </div>
            <div class="modal-body">
                <div class="row">
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