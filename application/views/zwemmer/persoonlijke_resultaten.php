<script>

    function haalResultaatOp(id)
    {
        $.ajax({type: "GET",
            url: site_url + "/zwemmer/wedstrijdresultaat/haalAjaxOp_Resultaten",
            data: {id: id},
            success: function (result) {
                $("#resultaat").html(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText)
            }
        });
    }

    $(document).ready(function () {
        $(".resultaat").click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            haalResultaatOp(id);
            $('#resultaatDialoog').modal('show');
        });

    });
</script>

<?php
$deelnameCount = 0;
$wedstrijdNamen = [];
$wedstrijden = [];
if (!empty($wedstrijddeelnames)) {
    foreach ($wedstrijddeelnames as $wedstrijddeelname) {
        if (count(array_keys($wedstrijdNamen, $wedstrijddeelname->wedstrijd->naam)) < 1) {
            if ($wedstrijddeelname->resultaatId != null) {
                $wedstrijdNamen[$deelnameCount] = $wedstrijddeelname->wedstrijd->naam;
                $wedstrijden[$deelnameCount]['naam'] = $wedstrijddeelname->wedstrijd->naam;
                $wedstrijden[$deelnameCount]['id'] = $wedstrijddeelname->wedstrijd->id;
                $deelnameCount++;
            }
        }
    }
}
?>

<h1 class="">Resultaten bekijken</h1>
<hr>
<h3>Resultaten</h3>

<table class="table">
    <tr>
        <th>Naam</th>
        <th>Actie</th>
    </tr>

    <?php
    $wedstrijdenCount = 0;
    if (!empty($wedstrijden)) {
        foreach ($wedstrijden as $wedstrijd) {
            echo
          "<tr>
            <td>" . $wedstrijden[$wedstrijdenCount]['naam'] . "</td>
            <td>" .  divAnchor('', 'Bekijken', array('class' => 'resultaat', 'data-id' => $wedstrijden[$wedstrijdenCount]['id'])) ."</td>
          </tr>";
            $wedstrijdenCount++;
        }
    }
    ?>
</table>

<div class="modal fade" id="resultaatDialoog" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Resultaat</h4>
            </div>
            <div class="modal-body">
                <p><div id="resultaat"></div></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
            </div>
        </div>

    </div>
</div>
