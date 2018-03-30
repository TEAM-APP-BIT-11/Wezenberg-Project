<?php
var_dump($evenement);
?>

<h1><?php echo ucfirst($evenement->type->type) . ' ';?>bewerken</h1>

<form>
    <table>
        <tr>
            <td>
                <div class="form-group">
                    <label for="evenementType">Type evenement</label>
                    <input type="text" class="form-control" id="evenementType" name="evenementType" value="<?php echo ucfirst($evenement->type->type);?>" readonly>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label for="begindatum">Begindatum</label>
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
            <td>
                <div class="form-group">
                    <label for="einddatum">Einddatum</label>
                    <input type="date" class="form-control" id="einddatum" name="einddatum" value="<?php echo $evenement->einddatum;?>">
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
                        <option><?php echo $evenement->locatie->naam;?></option>
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
        <tr>
            <td></td>
            <td></td>
        </tr>
    </table>
</form>