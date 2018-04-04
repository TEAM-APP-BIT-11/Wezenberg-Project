<?php
var_dump($evenement);
?>

<script type="text/javascript">
    $(document).ready(function(){
        var isNieuwEvenement = "<?php echo $isNieuwEvenement; ?>";
        $('#bewerkControls').click(function(e){
            if($(e.target).text() == 'Opslaan'){
                if(isNieuwEvenement){
                    $('#bewerkEvenementForm').attr('action', site_url + '/trainer/Evenement/voegToe');
                } else{
                    $('#bewerkEvenementForm').attr('action', site_url + '/trainer/Evenement/pasAan');
                }
                $('#bewerkEvenementForm').submit();
            }
        });

    });
</script>

<h1>
    <?php 
    echo ucfirst($evenement->type->type) . ' ';
    if($isNieuwEvenement){
        echo "toevoegen";
    } else{
        echo "bewerken";
    }   
    ?>
</h1>


<table>
    <form method="post" id="bewerkEvenementForm">
        <input type="number" name="evenementId" value="<?php echo $evenement->id;?>" hidden>
        <input type="number" name="evenementReeks" value="<?php echo $evenement->evenementReeksId;?>" hidden>
        <tr>
            <td>
                <div class="form-group">
                    <label for="evenementType">Type evenement</label>
                    <input type="number" id="evenementType" name="evenementType" value="<?php echo $evenement->type->id;?>" hidden>
                    <input type="text" class="form-control" value="<?php echo ucfirst($evenement->type->type);?>" readonly>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="begindatum"><?php if($evenement->type->type == "training"){echo "Datum";}else{echo "Begindatum";}?></label>
                    <input type="date" class="form-control" id="begindatum" name="begindatum" value="<?php echo $evenement->begindatum;?>">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label for="naam">Naam</label>
                    <input type="text" class="form-control" id="naam" name="naam" value="<?php echo ucfirst($evenement->naam);?>">
                </div>
            </td>
            <td <?php if($evenement->type->type == "training"){echo "hidden";}?>>
                <div class="form-group">
                    <label for="einddatum">Einddatum</label>
                    <input type="date" class="form-control" id="einddatum" name="einddatum" value="<?php echo $evenement->einddatum;?>">
                </div>
            </td>
            <td <?php if($evenement->type->type == "training"){echo "hidden";}?>>
                <div class="form-group">
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label for="beginuur">Beginuur</label>
                    <input type="time" class="form-control" id="beginuur" name="beginuur" value="<?php echo $evenement->beginuur;?>">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="einduur">Einduur</label>
                    <input type="time" class="form-control" id="einduur" name="einduur" value="<?php echo $evenement->einduur;?>">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="locatie">Locatie</label>
                    <select class="form-control" id="locatie" name="locatie">
                        <option value="<?php echo $evenement->locatie->id;?>"><?php echo $evenement->locatie->naam;?></option>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label for="beschrijving">Beschrijving</label>
                    <input type="text" class="form-control" id="beschrijving" name="beschrijving" value="<?php echo $evenement->extraInfo;?>">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <label for="alleZwemmers">Alle zwemmers</label>
                    <select size="<?php echo count($zwemmers);?>" class="form-control" id="alleZwemmers" name="alleZwemmers">
                        <?php
                        foreach($zwemmers as $zwemmer){
                            echo '<option>' . ucfirst($zwemmer->voornaam) . ' ' . ucfirst($zwemmer->familienaam) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                </div>
                <div class="form-group">
                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="deelnemendeZwemmers">Deelnemende zwemmers</label>
                    <select size="<?php echo count($zwemmers);?>" class="form-control" id="deelnemendeZwemmers" name="deelnemendeZwemmers">
                        <?php
                        foreach($evenement->deelnames as $deelname){
                            echo '<option>' . ucfirst($deelname->persoon->voornaam) . ' ' . ucfirst($deelname->persoon->familienaam) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </td>
        </tr>
    </form>
    <tr id="bewerkControls">
        <td><?php echo anchor($this->config->site_url() . '/trainer/Evenement/beheren', 'Annuleren', 'class="btn btn-primary"');?></td>
        <td><button class="btn btn-primary">Opslaan</button></td>
    </tr>
</table>
