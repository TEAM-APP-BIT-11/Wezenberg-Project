<div class="row text-center">
    <h2 class="text-center">Zwemmers</h2>
    <?php
    $lijstzwemmers = "";
    foreach ($zwemmers as $zwemmer) {

        if($zwemmer->actief == 1)
        {
            echo '<div class="col-md-4">';
            echo '<div class="thumbnail">';
            echo toonAfbeelding('personen/' . $zwemmer->foto , 'width="250px" height="250px"');
            echo '<div class="caption">';
            echo '<h3>' . ucfirst($zwemmer->voornaam) . ' ' . ucwords($zwemmer->familienaam) . '</h3>';
            echo '<p>' . anchor('bezoeker/Home/zwemmer/' . $zwemmer->id, 'Meer info', 'class="btn btn-primary"') . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>

</div>
<a href="javascript:history.go(-1);">
    <button type="button" class="btn btn-warning">Terug</button>
</a>
