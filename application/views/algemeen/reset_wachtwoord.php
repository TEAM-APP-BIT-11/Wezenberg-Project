<?php
/**
 * @file resetwachtwoord.php
 *
 * View waarin de gebruiker zijn/haar wachtwoord kan aanpassen.
 * - toont foutmelding als wachtwoord niet overeen komt.
 * - gebruikt bootstrap success & danger alert
 */
?>

<script>
    
    function wachtwoordCorrect(nieuwWW)
    {
        $.ajax({type : "POST",
                url : site_url + "/welcome/wijzigWachtwoord/" ,
                data : {nieuwWW : nieuwWW},
                success : function(){
                    $("#success").show();
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
        });

    }

    $(document).ready(function () {
        
        $("#danger").hide();
        
        $("#success").hide();
        
        $('#knop').click(function() {
            var nieuw = $('#nieuwWW').val();
            var herhaling = $('#herhalingWW').val();
            
            if (nieuw == herhaling)
            {
                $("div.wachtwoord").hide();
                $("#danger").hide();
                wachtwoordCorrect(nieuw);
            }
            else
            {
                $("#danger").show();
            }
            
        });
        
    });

</script>

<?php
$attributen = array('name' => 'mijnFormulier');
echo form_hidden('id', $persoon->id);
?>

<div class="wachtwoord">
    <h1>Wachtwoord wijzigen</h1>
    <?php echo "<h3>" . $persoon->voornaam . " " . $persoon->familienaam . "</h3>" ?>

    <p><?php echo form_label('Nieuw wachtwoord:', 'wachtwoord'); ?></p>
    <p><input type="password" name="nieuw" id="nieuwWW"><p>

    <p><?php echo form_label('Herhaal wachtwoord:', 'wachtwoord' ); ?></p>
    <p><input type="password" name="herhaling" id="herhalingWW"><p>

    <p><?php echo form_button(array("content" => "Wijzig wachtwoord", "class" => "btn btn-primary", "id" => "knop")); ?></p>
    
    <p><?php 

    echo anchor('welcome/wijzig/' . $persoon->id, "Terug"); 

    ?></p>
</div>

    <div class="alert alert-danger" id="danger">
        <strong>Fout! </strong><p>Het wachtwoord komt niet overeen.</p>
    </div>
    
    <div class="alert alert-success" id="success">
        <strong>OK! </strong><p>Het wachtwoord is veranderd.</p>
        <?php echo anchor('welcome/wijzig/' . $persoon->id, "Terug"); ?>        
    </div>


<?php echo form_close(); ?>

