<?php $dagen = array('Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag');?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#opslaan").click(function(){
            $("#nieuweTrainingenForm").submit();
        });
    });
</script>

<h1>Trainingen toevoegen</h1>
<form id="nieuweTrainingenForm" method="post" action="<?php echo $this->config->site_url() . '/trainer/Evenement/voegNieuweTrainingenToe';?>">
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="type">Type Evenement</label>
            <input name="type" class="form-control" type="text" value="Training" readonly>
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
            <label for="begindatum">Begindatum</label>
            <input name="begindatum" class="form-control" type="date" value="">
        </div>
        <div class="col-md-2 form-group">
            <label for="einddatum">Einddatum</label>
            <input name="einddatum" class="form-control" type="date" value="">
        </div>
    </div>
    <div class="row form-group">
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
                <option value="" disabled selected>Choose a location</option>
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
            <select name="alleZwemmers" class="form-control" size="<?php echo count($zwemmers);?>">
                <?php
                foreach($zwemmers as $zwemmer){
                    echo '<option>' . ucfirst($zwemmer->voornaam) . ' ' . ucfirst($zwemmer->familienaam) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-2 form-group">
            <div><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span></div>
            <div><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></div>
        </div>
        <div class="col-md-3 form-group">
            <label for="deelnemendeZwemmers">Deelnemende zwemmers</label>
            <select name="deelnemendeZwemmers" class="form-control" size="<?php echo count($zwemmers);?>"></select>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-1"><?php echo anchor($this->config->site_url() . '/trainer/Evenement/beheren', 'Annuleren', 'class="btn btn-primary"');?></div>
    <div class="col-md-1"><button id="opslaan" class="btn btn-primary">Opslaan</button></div>
    <div class="col-md-3"></div>
</div>