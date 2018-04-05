<?php
$lijstzwemmers = "";
foreach ($zwemmers as $zwemmer) {
    $lijstzwemmers .= '<div class="col-md-3">' . $zwemmer->voornaam . ' ' . $zwemmer->familienaam . '<br />' . anchor('bezoeker/Home/zwemmer/' . $zwemmer->id, 'Bekijken', 'class="btn btn-primary"') . '</div>';
}

?>
<div class="row">
    <?php echo $lijstzwemmers; ?>

</div>


