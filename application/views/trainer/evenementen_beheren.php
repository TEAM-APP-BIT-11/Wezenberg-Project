<?php
/**
 * @file evenementen_beheren.php
 * @author Senne Cools
 * 
 * View waarin de gebruiker een overzicht krijgt van de bestaande evenementen en waaruit hij nieuwe evenementen kan aanmaken
 * - krijgt de variabelen $evenementen, $titel, $eindverantwoordelijke, en $evenementreeksen binnen
 * - gebruikt confirmation JavaScript plugin
 * - gebruikt Bootstrap tab-panes
 */

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
                            if(evenementen[i].einduur !== null){
                                $(lijst).append('<option value="' + evenementen[i].id +'">' + evenementen[i].begindatum + ' van ' + evenementen[i].beginuur + ' tot ' + evenementen[i].einduur + '</option>');
                            } else {
                                $(lijst).append('<option value="' + evenementen[i].id +'">' + evenementen[i].begindatum + ' om ' + evenementen[i].beginuur + '</option>');
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
    $(document).ready(function(){
        $('#trainingsReeksen').change(function(){
            haalEvenementenOp($('#trainingsReeksen').val()[0], 'training');
        });
        $('#overigeReeksen').change(function(){
            haalEvenementenOp($('#overigeReeksen').val()[0], 'overige');
        });
        $('#trainingControls button').click(function(e){
            if($(e.target).text() === 'Training verwijderen'){
                $.confirm({
                    title: 'Training verwijderen',
                    content: 'Bent u zeker dat u deze training wil verwijderen?',
                    buttons: {
                        Ja: function () {
                            $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/verwijderEvenement');
                            $('#trainingenForm').submit();
                        },
                        Nee: function () {
                            $.alert('De training werd niet verwijderd.');
                        }
                    }
                });
            }
            if($(e.target).text() === 'Training bewerken'){
                $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/bewerkEvenement');
                $('#trainingenForm').submit();
            }
            
        });
        $('#trainingReeksControls button').click(function(e){
            if($(e.target).text() === 'Reeks verwijderen'){
                $.confirm({
                    title: 'Trainingreeks verwijderen',
                    content: 'Bent u zeker dat u deze reeks trainingen wil verwijderen?',
                    buttons: {
                        Ja: function () {
                            $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/verwijderReeks');
                            $('#trainingenForm').submit();
                        },
                        Nee: function () {
                            $.alert('De reeks werd niet verwijderd.');
                        }
                    }
                });
            }
            if($(e.target).text() === 'Reeks bewerken'){
                $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/bewerkReeks');
                $('#trainingenForm').submit();
            }
        });
        $('#overigeReeksControl button').click(function(e){
            if($(e.target).text() === 'Reeks verwijderen'){
                $.confirm({
                    title: 'Overige reeks verwijderen',
                    content: 'Bent u zeker dat u deze reeks evenementen wil verwijderen?',
                    buttons: {
                        Ja: function () {
                            $('#overigeForm').attr('action', site_url + '/trainer/Evenement/verwijderReeks');
                            $('#overigeForm').submit();
                        },
                        Nee: function () {
                            $.alert('De reeks werd niet verwijderd.');
                        }
                    }
                });
            }
            if($(e.target).text() === 'Reeks bewerken'){
                $('#overigeForm').attr('action', site_url + '/trainer/Evenement/bewerkReeks');
                $('#trainingenForm').submit();
            }
        });
        $('#overigeControls button').click(function(e){
            if($(e.target).text() === 'Overige verwijderen'){
                $.confirm({
                    title: 'Evenement verwijderen',
                    content: 'Bent u zeker dat u dit evenement wil verwijderen?',
                    buttons: {
                        Ja: function () {
                            $('#overigeForm').attr('action', site_url + '/trainer/Evenement/verwijderEvenement');
                            $('#overigeForm').submit();
                        },
                        Nee: function () {
                            $.alert('Het evenement werd niet verwijderd.');
                        }
                    }
                });
            }
            if($(e.target).text() === 'Overige bewerken'){
                $('#overigeForm').attr('action', site_url + '/trainer/Evenement/bewerkEvenement');
                $('#overigeForm').submit();
            }
        });
        $('#medischeControls button').click(function(e){
            if($(e.target).text() === 'Medische test verwijderen'){
                $.confirm({
                    title: 'Medische test verwijderen',
                    content: 'Bent u zeker dat u deze medische test wil verwijderen?',
                    buttons: {
                        Ja: function () {
                            $('#medischForm').attr('action', site_url + '/trainer/Evenement/verwijderEvenement');
                            $('#medischForm').submit();
                        },
                        Nee: function () {
                            $.alert('De medische test werd niet verwijderd.');
                        }
                    }
                });
            }
            if($(e.target).text() === 'Medische test bewerken'){
                $('#medischForm').attr('action', site_url + '/trainer/Evenement/bewerkEvenement');
                $('#medischForm').submit();
            }
        });
        $('#stageControls button').click(function(e){
            if($(e.target).text() === 'Stage verwijderen'){
                $.confirm({
                    title: 'Stage verwijderen',
                    content: 'Bent u zeker dat u deze stage wil verwijderen?',
                    buttons: {
                        Ja: function () {
                            $('#stageForm').attr('action', site_url + '/trainer/Evenement/verwijderEvenement');
                            $('#stageForm').submit();
                        },
                        Nee: function () {
                            $.alert('De stage werd niet verwijderd.');
                        }
                    }
                });
            }
            if($(e.target).text() === 'Stage bewerken'){
                $('#stageForm').attr('action', site_url + '/trainer/Evenement/bewerkEvenement');
                $('#stageForm').submit();
            }
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
            <input name="typeId" value="1" hidden>
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
                    <label for="evenementId">Specifieke trainingen</label>
                    <select name="evenementId" class="form-control" id="trainingenLijst" multiple></select>
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
        <form id="medischForm" method="POST">
            <input name="typeId" value="2" hidden>
            <div class="row">
                <div class="col-md-8 form-group">
                    <label for="evenementId">Medische Testen</label>
                    <select name="evenementId" class="form-control" id="testenLijst" multiple>
                        <?php
                        foreach($medischeTesten as $medischeTest){
                            if($medischeTest->einddatum != null){
                                echo '<option value="' . $medischeTest->id . '">' . zetOmNaarDDMMYYYY($medischeTest->begindatum) . ': ' . $medischeTest->naam . ' om ' . zetOmNaarHHMM($medischeTest->beginuur) . '</option>';
                            } else{
                                echo '<option value="' . $medischeTest->id . '">' . zetOmNaarDDMMYYYY($medischeTest->begindatum) . ': ' . $medischeTest->naam . ' om ' . zetOmNaarHHMM($medischeTest->beginuur) . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <div id="medischeControls" class="controls">
                        <button class="btn btn-primary" type="button">Medische test verwijderen</button>
                        <button class="btn btn-primary" type="button">Medische test bewerken</button>
                    </div>
                </div>
            </div>
        </form>
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
        <form id="stageForm" method="POST">
            <input name="typeId" value="3" hidden>
            <div class="row">
                <div class="col-md-8 form-group">
                    <label for="evenementId">Stages</label>
                    <select name="evenementId" class="form-control" id="stageLijst" multiple>
                        <?php
                        foreach($stages as $stage){
                            if($stage->einddatum != null){
                                if($stage->einduur != null){
                                    echo '<option value="' . $stage->id . '">' . zetOmNaarDDMMYYYY($stage->begindatum) . ' - ' . zetOmNaarDDMMYYYY($stage->einddatum) . ': ' . $stage->naam . ' van ' . zetOmNaarHHMM($stage->beginuur) . ' tot ' . zetOmNaarHHMM($stage->einduur) . '</option>';
                                } else{
                                    echo '<option value="' . $stage->id . '">' . zetOmNaarDDMMYYYY($stage->begindatum) . ' - ' . zetOmNaarDDMMYYYY($stage->einddatum) . ': ' . $stage->naam . ' om ' . zetOmNaarHHMM($stage->beginuur) . '</option>';
                                }
                            } else{
                                if($stage->einduur != null){
                                    echo '<option value="' . $stage->id . '">' . zetOmNaarDDMMYYYY($stage->begindatum) . ': ' . $stage->naam . ' van ' . zetOmNaarHHMM($stage->beginuur) . ' tot ' . zetOmNaarHHMM($stage->einduur) . '</option>';
                                } else{
                                    echo '<option value="' . $stage->id . '">' . zetOmNaarDDMMYYYY($stage->begindatum) . ': ' . $stage->naam . ' om ' . zetOmNaarHHMM($stage->beginuur) . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                    <div id="stageControls" class="controls">
                        <button class="btn btn-primary" type="button">Stage verwijderen</button>
                        <button class="btn btn-primary" type="button">Stage bewerken</button>
                    </div>
                </div>
            </div>
        </form>
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
            <input name="typeId" value="3" hidden>
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
                    <label for="evenementId">Specifieke evenementen</label>
                    <select name="evenementId" class="form-control" id="overigeLijst" multiple></select>
                    <div id="overigeControls" class="controls">
                        <button class="btn btn-primary" type="button">Overige verwijderen</button>
                        <button class="btn btn-primary" type="button">Overige bewerken</button>
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
