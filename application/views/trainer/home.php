<script type="text/javascript">
    function verwijderMelding(id){
        console.log(id);
        //AJAX voor melding te verwijderen nog coderen
    };

    $(document).ready(function(){
        $('.alert-dismissible button').click(function(){
            verwijderMelding($(this).data('id'));
        });
    });
</script>





<?php
$meldingenlijst = "";

foreach($meldingen as $melding){
    $meldingenlijst .= '<div class="alert alert-info alert-dismissible" role="alert">';
    $meldingenlijst .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close" data-id="' . $melding->id . '"><span aria-hidden="true">x</span></button>';
    $meldingenlijst .= '<strong>' . $melding->titel . '</strong>  <span class="label label-';

    if($melding->gelezen){
        $meldingenlijst .= 'default';
    }
    else {
        $meldingenlijst .= 'primary';
    }
    $meldingenlijst .= '">' . zetOmNaarHHMMDDMMYYYY($melding->momentVerzonden). '</span><br>' . $melding->boodschap;
    $meldingenlijst .= '</div>';
}
?>


<div class="col-md-10 content">

    <h1 class="">Trainer home</h1>
    <hr>
    <h3>Meldingen</h3>

    <?php echo $meldingenlijst; ?>



</div>

