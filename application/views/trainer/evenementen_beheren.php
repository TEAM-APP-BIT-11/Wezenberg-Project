<?php
$trainingReeksen = $overigeReeksen = $medischeTesten = $stages = [];
foreach($evenementen as $evenement){
    if($evenement->type->type == 'training'){
        foreach($evenementreeksen as $evenementreeks){
            if($evenement->evenementReeksId == $evenementreeks->id && !in_array($evenementreeks, $trainingReeksen)){
                array_push($trainingReeksen, $evenementreeks);
            }
        }
    }
    if($evenement->type->type == 'medische test'){
        array_push($medischeTesten, $evenement);
    }
    if($evenement->type->type == 'stage'){
        array_push($stages, $evenement);
    }
    if($evenement->type->type == 'overige'){
        foreach($evenementreeksen as $evenementreeks){
            if($evenement->evenementReeksId == $evenementreeks->id && !in_array($evenementreeks, $overigeReeksen)){
                array_push($overigeReeksen, $evenementreeks);
            }
        }
    }
}
?>

<script type="text/javascript">
    function haalEvenementenOp(evenementReeksId, evenementType){
        $.ajax({type: "GET",
                url : site_url + "/trainer/Evenement/haalJsonOp_Evenementen",
                data : {evenementReeksId: evenementReeksId},
                success : function(result){
                    try {
                        var lijst;
                        if(evenementType === 'training'){
                            lijst = '#trainingenLijst';
                        } else{
                            lijst = '#overigeLijst';
                        }
                        $(lijst).html("");
                        var evenementen = jQuery.parseJSON(result);
                        for(var i = 0; i < evenementen.length; i++){
                            $(lijst).append('<option value="' + evenementen[i].id +'">' + evenementen[i].begindatum + ': ' + evenementen[i].beginuur + ' - ' + evenementen[i].einduur + '</option>');
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
    $(document).ready(function(){
        $('#trainingsReeksen').change(function(){
            haalEvenementenOp($('#trainingsReeksen').val()[0], 'training');
        });
        $('#overigeReeksen').change(function(){
            haalEvenementenOp($('#overigeReeksen').val()[0], 'overige');
        });
        $('#trainingControls button').click(function(e){
            if($(e.target).text() === 'Training verwijderen'){
                $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/verwijderEvenement');
            }
            if($(e.target).text() === 'Training bewerken'){
                $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/bewerkEvenement');
            }
            $('#trainingenForm').submit();
        });
        $('#trainingReeksControls button').click(function(e){
            if($(e.target).text() === 'Reeks verwijderen'){
                $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/verwijderReeks');
            }
            if($(e.target).text() === 'Reeks bewerken'){
                $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/bewerkReeks');
            }
            $('#trainingenForm').submit();
        });
    });
</script>

<style>
    .evenementToevoegen{
        margin-top: 25px;
        text-align: center;
    }
    .controls{
        margin-top: 10px;
        text-align: center;
    }
    .controls button:first-child{
        margin-right: 50px;
    }
</style>

<h1>Evenementen beheren</h1>
<hr>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#trainingen">Trainingen</a></li>
    <li><a data-toggle="tab" href="#testen">Medische testen</a></li>
    <li><a data-toggle="tab" href="#stages">Stages</a></li>
    <li><a data-toggle="tab" href="#overige">Overige</a></li>
</ul>
<div class="tab-content">
    <!--Trainingen-->
    <div id="trainingen" class="tab-pane fade in active">
        <h3>Trainingen beheren</h3>
        <hr>
        <form id="trainingenForm" method="POST">
            <input name="reeksSoort" value="trainingReeks" hidden>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="trainingsreeksen">Trainingreeksen</label>
                    <select name="trainingsreeksen" class="form-control" id="trainingsReeksen" multiple>
                        <?php
                        foreach($trainingReeksen as $trainingReeks){
                            echo '<option value="' . $trainingReeks->id . '">' . $trainingReeks->naam . '</option>';
                        }
                        ?>
                    </select>
                    <div id="trainingReeksControls" class="controls">
                        <button class="btn btn-primary" type="button">Reeks verwijderen</button>
                        <button class="btn btn-primary" type="button">Reeks bewerken</button>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <label for="trainingsId">Specifieke trainingen</label>
                    <select name="trainingsId" class="form-control" id="trainingenLijst" multiple></select>
                    <div id="trainingControls" class="controls">
                        <button class="btn btn-primary" type="button">Training verwijderen</button>
                        <button class="btn btn-primary" type="button">Training bewerken</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-8 evenementToevoegen form-group">
                <hr>
                <?php echo anchor($this->config->site_url() . '/trainer/Evenement/laadEvenement/1/true', 'Evenementen toevoegen', 'class="btn btn-primary"');?>
            </div>
        </div> 
    </div>
    <!--Medische testen-->
    <div id="testen" class="tab-pane fade">
        <h3>Medische testen beheren</h3>
        <hr>
        <div class="row">
            <div class="col-md-8 form-group">
                <label for="testen">Medische Testen</label>
                <select name="testen" class="form-control" id="testenLijst" multiple>
                    <?php
                    foreach($medischeTesten as $medischeTest){
                        echo '<option>' . $medischeTest->naam . '</option>';
                    }
                    ?>
                </select>
                <div id="testControls" class="controls">
                    <button class="btn btn-primary" type="button">Medische test verwijderen</button>
                    <button class="btn btn-primary" type="button">Medische test bewerken</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 evenementToevoegen form-group">
                <hr>
                <?php echo anchor($this->config->site_url() . '/trainer/Evenement/laadEvenement/2/true', 'Evenementen toevoegen', 'class="btn btn-primary"');?>
            </div>
        </div>    
    </div>
    <!--Stages-->
    <div id="stages" class="tab-pane fade">
        <h3>Stages beheren</h3>
        <hr>
        <div class="row">
            <div class="col-md-8 form-group">
                <label for="stages">Stages</label>
                <select name="stages" class="form-control" id="stageLijst" multiple>
                    <?php
                    foreach($stages as $stage){
                        echo '<option>' . $stage->naam . '</option>';
                    }
                    ?>
                </select>
                <div id="stageControls" class="controls">
                    <button class="btn btn-primary" type="button">Stage verwijderen</button>
                    <button class="btn btn-primary" type="button">Stage bewerken</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 evenementToevoegen form-group">
                <hr>
                <?php echo anchor($this->config->site_url() . '/trainer/Evenement/laadEvenement/3/true', 'Evenementen toevoegen', 'class="btn btn-primary"');?>
            </div>
        </div>
    </div>
    <!--Overige evenementen-->
    <div id="overige" class="tab-pane fade">
        <h3>Overige evenementen beheren</h3>
        <hr>
        <form id="overigeForm" method="POST">
            <input name="reeksSoort" value="overigeReeks" hidden>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="overigereeksen">Overige reeksen</label>
                    <select name="overigereeksen" class="form-control" id="overigeReeksen" multiple>
                        <?php
                        foreach($overigeReeksen as $overigeReeks){
                            echo '<option value="' . $overigeReeks->id . '">' . $overigeReeks->naam . '</option>';
                        }
                        ?>
                    </select>
                    <div id="overigeReeksControl" class="controls">
                        <button class="btn btn-primary" type="button">Reeks verwijderen</button>
                        <button class="btn btn-primary" type="button">Reeks bewerken</button>
                    </div>
                </div>
                <div class="col-md-4 form-group">
                    <label for="overigeId">Specifieke evenementen</label>
                    <select name="overigeId" class="form-control" id="overigeLijst" multiple></select>
                    <div id="overigeControls" class="controls">
                        <button class="btn btn-primary" type="button">Evenement verwijderen</button>
                        <button class="btn btn-primary" type="button">Evenement bewerken</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-8 evenementToevoegen form-group">
                <hr>
                <?php echo anchor($this->config->site_url() . '/trainer/Evenement/laadEvenement/4/true', 'Evenementen toevoegen', 'class="btn btn-primary"');?>
            </div>
        </div>
    </div>
</div>
