<?php $dagen = array('Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag');?>

<script type="text/javascript">
    $(document).ready(function(){  
        $(function(){
            //moment.locale('nl-be');
            //moment().format('L');
            $('#datetimepicker1').datetimepicker({
                locale: 'nl-be',
                format: 'L'
            });
            
        });
        $("#opslaan").click(function(){
            $("#nieuweTrainingenForm").submit();
        });
        $("#type, #hoeveelheid").on('change', function(){
            var type = $("#type option:selected").text();
            var hoeveelheid = $('#hoeveelheid').val();
            switch(type){
                case 'Training':
                    if(hoeveelheid === 'enkel'){
                        $('#titel').html('Training toevoegen');
                    } else{
                        $('#titel').html('Trainingen toevoegen');
                    }
                    break;
                case 'Medische test':
                    if(hoeveelheid === 'enkel'){
                        $('#titel').html('Medische test toevoegen');
                    } else{
                        $('#titel').html('Medische testen toevoegen');
                    }
                    break;
                case 'Stage':
                    if(hoeveelheid === 'enkel'){
                        $('#titel').html('Stage toevoegen');
                    } else{
                        $('#titel').html('Stages toevoegen');
                    }
                    break;
                case 'Overige':
                    if(hoeveelheid === 'enkel'){
                        $('#titel').html('Evenement toevoegen');
                    } else{
                        $('#titel').html('Evenementen toevoegen');
                    }
                    break;
            }
            if(hoeveelheid === 'enkel'){
                $('#begindatum').html('Datum');
                $('.meerdere').hide();
            } else{
                $('#begindatum').html('Begindatum');
                $('.meerdere').show();
            }
        });
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
    .meerdere{
        display: none;
    }
    #zwemmerKnoppen button{
        width: 100%;
        height: 100%;
    }
</style>

<h1 id="titel"><?php echo ucfirst($type);?> toevoegen</h1>
<form id="nieuweTrainingenForm" method="post" action="<?php echo $this->config->site_url() . '/trainer/Evenement/voegNieuweTrainingenToe';?>">
    <div class="row">
        <div class="col-md-2 form-group">
            <label for="type">Type Evenement</label>
            <select name="type" id="type" class="form-control">
                <?php
                echo '<option value="' . $typeId . '" selected>' . ucfirst($type) . '</option>';
                foreach($types as $evenementType){
                    if($evenementType->id !== $typeId){
                        echo '<option value="' . $evenementType->id . '">' . ucfirst($evenementType->type) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-2 form-group">
            <label for="hoeveelheid">Hoeveelheid</label>
            <select name="hoeveelheid" id="hoeveelheid" class="form-control">
                <option value="enkel" selected>Enkel</option>
                <option value="meerdere">Meerdere</option>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="naam">Evenementnaam</label>
            <input name="naam" class="form-control" type="text" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 form-group">
            <label for="beginuur">Beginuur</label>
            <input name="beginuur" class="form-control" type="time" value="">
        </div>
        <div class="col-md-2 form-group">
            <label for="einduur">Einduur</label>
            <input name="einduur" class="form-control" type="time" value="">
        </div>
        <div class="col-md-2 form-group">
                <label for="begindatum" id="begindatum">Datum</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input name="begindatum" type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
        </div>
        <div class="col-md-2 form-group meerdere">
            <label for="einddatum">Einddatum</label>
            <input name="einddatum" class="form-control" type="date" value="">
        </div>
    </div>
    <div class="row form-group meerdere">
        <label>Gaat door op</label>
        <div class="col-md-12 form-group">
            <?php
            for($i = 0; $i < count($dagen); $i++){
                echo '<label class="checkbox-inline"><input type="checkbox" name="check_list[]" value="' . ($i+1) . '">' . $dagen[$i] . '</label>';
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="beschrijving">Beschrijving</label>
            <input name="beschrijving" class="form-control" type="text" value="">
        </div>
        <div class="col-md-4 form-group">
            <label for="locatie">Locatie</label>
            <select name="locatie" class="form-control">
                <option value="" disabled selected>Kies een locatie</option>
                <?php
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
                    echo '<option>' . ucfirst($zwemmer->voornaam) . ' ' . ucfirst($zwemmer->familienaam) . '</option>';
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
            <select name="deelnemendeZwemmers" id="deelnemendeZwemmers" class="form-control" size="<?php echo count($zwemmers);?>"></select>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-1"><?php echo anchor($this->config->site_url() . '/trainer/Evenement/beheren', 'Annuleren', 'class="btn btn-primary"');?></div>
    <div class="col-md-1"><button id="opslaan" class="btn btn-primary">Opslaan</button></div>
    <div class="col-md-3"></div>
</div>