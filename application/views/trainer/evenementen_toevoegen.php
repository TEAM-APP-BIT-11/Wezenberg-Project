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
                $("#begindatum").html('Begindatum');
                $("#einddatum input").prop('disabled', false);
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
                    $("#begindatum").html('Datum');
                    $("#einddatum input").prop('disabled', true);
                    $("#dagen").hide();
                } else{
                    $("#hoeveelheid").prop('disabled', false);
                    $("#begindatum").html('Begindatum');
                    $("#einddatum input").prop('disabled', false);
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
    });
</script>

<style>
    #dagen{
        <?php if($isNieuw && !$isReeks){echo 'display: none;';}?>
    }
    #zwemmerKnoppen button{
        width: 100%;
        height: 100%;
    }
    #dagenLabel{
        margin-left: 15px;
    }
    #zwemmerKnoppen{
        margin-top: 25px;
    }
    #zwemmerKnoppen div:first-child{
        margin-bottom: 10px;
    }
    textarea{
        resize: vertical;
    }
    #formControls div:first-child{
        text-align: right;
    }
    #formControls{
        margin-top: 50px;
    }
</style>

<h1 id="titel"><?php echo ucfirst($evenementtype->type);?> toevoegen</h1>
<hr>
<form id="nieuweEvenementenForm" method="post" action="<?php echo $this->config->site_url() . '/trainer/Evenement/voegNieuweEvenementenToe';?>">
    <input id="zwemmers" name="zwemmers" value="" hidden>
    <div class="row">
        <div class="col-md-2 form-group">
            <label for="type">Type Evenement</label>
            <select name="type" id="type" class="form-control" <?php if(!$isNieuw){echo 'disabled';}?>
                <?php
                echo '<option value="' . $evenementtype->id . '" selected>' . ucfirst($evenementtype->type) . '</option>';
                foreach($types as $evenementType){
                    if($evenementType->id !== $typeId){
                        echo '<option value="' . $evenementType->id . '">' . ucfirst($evenementType->type) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div id="hoeveelheidskolom" class="col-md-2 form-group">
            <label for="hoeveelheid">Hoeveelheid</label>
            <select name="hoeveelheid" id="hoeveelheid" class="form-control" <?php if($evenementtype->type == 'stage' || $evenementtype->type == 'medische test' || !$isNieuw){echo ' disabled';}?>>
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
            <label for="naam" id="naam">Evenementnaam</label>
            <input name="naam" class="form-control" type="text" value="<?php if(!$isNieuw){echo $evenement->naam;}?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 form-group">
            <label for="begindatum" id="begindatum"><?php if(!$isNieuw && $isReeks){echo 'Begindatum';}else{echo 'Datum';}?></label>
            <div class='input-group date' id='datetimepickerBegindatum'>
                <input name="begindatum" type='text' class="form-control" <?php if(!$isNieuw){echo 'value="' . zetOmNaarDDMMYYYY($evenement->begindatum) . '"';}?>/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div id="einddatum" class="col-md-2 form-group meerdere">
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
            <label for="beginuur">Beginuur</label>
            <div class='input-group date' id='datetimepickerBeginuur'>
                <input name="beginuur" type='text' class="form-control" <?php if(!$isNieuw){echo 'value="' . $evenement->beginuur . '"';}?>/>
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
        <label id="dagenLabel">Gaat door op</label>
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
            <textarea name="beschrijving" class="form-control" <?php if(!$isNieuw && $evenement->extraInfo != ""){echo 'value="' . $evenement->extraInfo . '"';}?> rows="3"></textarea>
        </div>
        <div class="col-md-4 form-group">
            <label for="locatie">Locatie</label>
            <select name="locatie" class="form-control">
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