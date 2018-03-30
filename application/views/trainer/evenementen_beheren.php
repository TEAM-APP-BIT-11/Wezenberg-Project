<script type="text/javascript">
    function haalTrainingenOp(evenementReeksNaam){
        $.ajax({type: "GET",
                url : site_url + "/trainer/Evenement/haalJsonOp_Trainingen",
                data : {evenementReeksNaam: evenementReeksNaam},
                success : function(result){
                    try {
                        $('#trainingenLijst').html("");
                        var trainingen = jQuery.parseJSON(result);
                        for(var i = 0; i < trainingen.length; i++){
                            $('#trainingenLijst').append('<option value="' + trainingen[i].id +'">' + trainingen[i].begindatum + ': ' + trainingen[i].beginuur + ' - ' + trainingen[i].einduur + '</option>');
                        }
                    } catch(error){
                        alert("--- ERROR IN JSON --" + result);
                    }
                },
                error: function(xhr, status, error){
                    alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
                }
        });
    }
    
    function bewerkTraining(functie, trainingsId){
        
    }

    $(document).ready(function(){
        $('#trainingsReeksen').change(function(){
            haalTrainingenOp($('#trainingsReeksen').val());
        });
        
        $('#trainingControls').click(function(e){
            if($(e.target).text() == 'Training verwijderen'){
                $('#trainingenForm').attr('action', site_url + '/trainer/Evenement/verwijder');
                $('#trainingenForm').submit();
            
            
                //var option = document.getElementById('trainingenLijst');
                //var trainingsId = e.options[e.selectedIndex].value;               
                //bewerkTraining('verwijder', trainingsId);
            }
            if($(e.target).text() == 'Training bewerken'){
            }
        });

    });
</script>


<h1>Evenementen beheren</h1>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#trainingen">Trainingen</a></li>
    <li><a data-toggle="tab" href="#stages">Stages</a></li>
    <li><a data-toggle="tab" href="#medische">Medische testen</a></li>
    <li><a data-toggle="tab" href="#overige">Overige</a></li>
</ul>
<div class="tab-content">
    <div id="trainingen" class="tab-pane fade in active">
        <h3>Trainingen beheren</h3>
        <table>
            <tr>
                <th>Trainingen:</th>
                <th>Specifieke training:</th>
            </tr>
            <tr>
                <td>
                    <form method="post" action="<?php echo site_url() . '/trainer/Evenement/bewerk/';?>">
                        <div class="form-group">
                            <select size="<?php echo count($evenementreeksen);?>" class="form-control" id="trainingsReeksen">
                                <?php
                                foreach($evenementreeksen as $evenementreeks){
                                    echo '<option>' . $evenementreeks->naam . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Reeks bewerken</button>
                    </form>
                </td>
                <td>
                    <form id="trainingenForm" method="post">
                        <div class="form-group">
                            <select multiple class="form-control" id="trainingenLijst">

                            </select>
                        </div>
                    </form>
                    <div id="trainingControls">
                        <button class="btn btn-primary">Training verwijderen</button>
                        <button class="btn btn-primary">Training bewerken</button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div id="stages" class="tab-pane fade">
        <h3>Stages beheren</h3>
        <form>
            <div class="form-group">
                <select multiple class="form-control" id="stageLijst">
                    <?php
                    foreach($evenementen as $evenement){
                        if($evenement->type->type == 'stage'){
                            echo '<option>' . $evenement->naam . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </form>
    </div>
    <div id="medische" class="tab-pane fade">
        <h3>Medische testen beheren</h3>
        <form>
            <div class="form-group">
                <select multiple class="form-control" id="testenLijst">
                    <?php
                    foreach($evenementen as $evenement){
                        if($evenement->type->type == 'medische test'){
                            echo '<option>' . $evenement->naam . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </form>
    </div>
    <div id="overige" class="tab-pane fade">
        <h3>Overige evenementen beheren</h3>
        <form>
            <div class="form-group">
                <select multiple class="form-control" id="overigeLijst">
                    <?php
                    foreach($evenementen as $evenement){
                        if($evenement->type->type == 'overige'){
                            echo '<option>' . $evenement->naam . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </form>
    </div>
</div>
