<script type="text/javascript">
    $(document).ready(function(){
        $('#opslaan').click(function(){
            $('#bewerkTrainingForm').submit();
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
    #zwemmerKnoppen button{
        width: 100%;
        height: 100%;
    }
</style>

<h1>Training bewerken</h1>
<form id="bewerkTrainingForm" method="post" action="<?php echo $this->config->site_url() . '/trainer/Evenement/pasAan';?>">
    <input name="evenementId" value="<?php echo $evenement->id;?>" hidden>
    <input name="evenementType" value="<?php echo $evenement->evenementTypeId;?>" hidden>
    <input name="evenementReeks" value="<?php echo $evenement->evenementReeksId;?>" hidden>
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="type">Type Evenement</label>
            <input name="type" class="form-control" type="text" value="Training" readonly>
        </div>
        <div class="col-md-4 form-group">
            <label for="naam">Evenementnaam</label>
            <input name="naam" class="form-control" type="text" value="<?php echo $evenement->naam;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 form-group">
            <label for="beginuur">Beginuur</label>
            <input name="beginuur" class="form-control" type="time" value="<?php echo $evenement->beginuur;?>">
        </div>
        <div class="col-md-2 form-group">
            <label for="einduur">Einduur</label>
            <input name="einduur" class="form-control" type="time" value="<?php echo $evenement->einduur;?>">
        </div>
        <div class="col-md-2 form-group">
            <label for="begindatum">Datum</label>
            <input name="begindatum" class="form-control" type="date" value="<?php echo $evenement->begindatum;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="beschrijving">Beschrijving</label>
            <input name="beschrijving" class="form-control" type="text" value="<?php echo $evenement->extraInfo;?>">
        </div>
        <div class="col-md-4 form-group">
            <label for="locatie">Locatie</label>
            <select name="locatie" class="form-control">
                <?php
                echo '<option value="' . $evenement->locatie->id . '" selected>' . $evenement->locatie->naam . '</option>';
                foreach($locaties as $locatie){
                    if($locatie->naam !== $evenement->locatie->naam){
                        echo '<option value="' . $locatie->id . '">' . $locatie->naam . '</option>';
                    } 
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 form-group">
            <label for="alleZwemmers">Alle zwemmers</label>
            <select id="alleZwemmers" name="alleZwemmers" class="form-control" size="<?php echo count($zwemmers);?>">
                <?php
                foreach($zwemmers as $zwemmer){
                    if(count($evenement->deelnames) != 0){
                        foreach($evenement->deelnames as $deelnemendeZwemmer){
                            if($deelnemendeZwemmer->persoon->id !== $zwemmer->id){
                                echo '<option value="' . $zwemmer->id . '">' . ucfirst($zwemmer->voornaam) . ' ' . ucfirst($zwemmer->familienaam) . '</option>';
                            }
                        } 
                    } else{
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
            <select id="deelnemendeZwemmers" name="deelnemendeZwemmers" class="form-control" size="<?php echo count($zwemmers);?>">
                <?php
                foreach($evenement->deelnames as $deelname){
                    echo '<option value="' . $deelname->persoon->id . '">' . ucfirst($deelname->persoon->voornaam) . ' ' . ucfirst($deelname->persoon->familienaam) . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-1"><?php echo anchor($this->config->site_url() . '/trainer/Evenement/beheren', 'Annuleren', 'class="btn btn-primary"');?></div>
    <div class="col-md-1"><button id="opslaan" class="btn btn-primary">Opslaan</button></div>
    <div class="col-md-3"></div>
</div>
