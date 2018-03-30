<script type="text/javascript">
    function verwijderMelding(meldingId) {
        $.ajax({
            type: "POST",
            url: site_url + "/Welcome/MeldingGelezen",
            data: {meldingId: meldingId},
            success: function (result) {
                try {

                } catch (error) {
                    alert("--- ERROR IN JSON --" + result);
                }
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
            }
        });
    };

    $(document).ready(function () {
        $('.alert-dismissible button').click(function () {
            verwijderMelding($(this).data('id'));
        });
    });
</script>


<?php
$meldingenlijst = "";

foreach ($meldingen as $melding) {
    $meldingenlijst .= '<div class="alert alert-info alert-dismissible" role="alert">';
    $meldingenlijst .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close" data-id="' . $melding->id . '"><span aria-hidden="true">x</span></button>';
    $meldingenlijst .= '<strong>' . $melding->titel . '</strong>  <span class="label label-primary">' . zetOmNaarHHMMDDMMYYYY($melding->momentVerzonden) . '</span><br>' . $melding->boodschap;
    $meldingenlijst .= '</div>';
}
?>


<div class="col-md-10 content">

    <h1 class="">Zwemmer home</h1>
    <hr>
    <h3>Meldingen</h3>

    <?php echo $meldingenlijst; ?>


</div>

