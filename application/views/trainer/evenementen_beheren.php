<?php
/*
 * @file evenementen_beheren.php
 * 
 * View waarin een trainer een overzicht krijgt van alle bestaande evenementen en waar hij evenementen kan aanpassen en toevoegen
 * - krijgt een $evenementen-object binnen
 * - gebruikt Bootstrap-tabs
 */
?>
<div class="col-md-10 content">
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
                    <th>Trainingen</th>
                    <th>Specifieke trainingen</th>
                </tr>
                <tr>
                    <td>
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">Example multiple select</label>
                                <select multiple class="form-control" id="exampleFormControlSelect2">
                                    <?php
                                    foreach($evenementen as $evenement){
                                        echo '<option>' + $evenement->naam + '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>

        <div id="stages" class="tab-pane fade">
            <h3>Stages beheren</h3>
            <p>Hier komt inhoud van menu 1.</p>
        </div>

        <div id="medische" class="tab-pane fade">
            <h3>Medische testen beheren</h3>
            <p>Hier komt inhoud van menu 2.</p>
        </div>
        <div id="overige" class="tab-pane fade">
            <h3>Overige evenementen beheren</h3>
            <p>Hier komt inhoud van menu 2.</p>
        </div>
    </div>
</div>
