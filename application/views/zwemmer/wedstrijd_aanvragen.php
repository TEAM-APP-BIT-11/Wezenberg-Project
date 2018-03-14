<script type="text/javascript">

    function haalReeksenop (wedstrijdid){
        $.ajax({type: "GET",
        url : site_url + "/zwemmer/Wedstrijd/haalJsonOp_WedstrijdReeksen",
            data : { reeks : wedstrijdid},
            success : function(result){
                try {
                    var wedstrijdreeks = jQuery.parseJSON(result);
                    $("")
                    // HIER BEN IK BEZIG!
                }
                catch(error){
                    alert("--- ERROR IN JSON --\n" + result);
                }
            },
            error: function(xhr, status, error){
            alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
            }
        })
    }

    $(document).ready(function(){
        $('#wedstrijd').change(function(){
            console.log("TEST");
        });

    });

</script>


<?php

$lijst = "";


foreach($wedstrijdreeksen as $wedstrijdreeks){
    $lijst .= "<tr><td>" . $wedstrijdreeks->slag->naam .
        "</td><td>" . $wedstrijdreeks->afstand->afstand .
        "</td><td>" . zetOmNaarDDMMYYYY($wedstrijdreeks->datum) .
        "</td><td>" . $wedstrijdreeks->beginuur .
        "</td><td>" . "XXX" .
        "</td><td>" . "XXX STATUS" . "</td></tr>";
}

?>

<h1>Wedstrijd Aanvragen</h1>
<h3>Lijst van alle wedstrijden</h3>

<?php echo form_dropdownpro("Test", $wedstrijden, "id", "naam", "0", 'id="wedstrijd"'); ?>

<table class="table">
    <thead>
        <th>Slag</th>
        <th>Afstand</th>
        <th>Datum</th>
        <th>Uur</th>
        <th>Aanvragen</th>
        <th>Status</th>
    <thead>
    <tbody>
    <?php echo $lijst; ?>
    </tbody>
</table>
        