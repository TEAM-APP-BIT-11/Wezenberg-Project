<script>

    function haalResultaatOp(id)
    {
        $.ajax({type: "GET",
            url: site_url + "/zwemmer/wedstrijdresultaten/haalAjaxOp_Resultaten",
            data: {id: id},
            success: function (result) {
                $("#resultaat").html("result");
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



<h1 class="">Resultaten bekijken</h1>
<hr>
<h3>Resultaten</h3>

<table class="table">
    <tr>
        <th>Naam</th>
        <th>Actie</th>
    </tr>

    <?php
    foreach ($wedstrijddeelnames as $wedstrijddeelname) {
        echo
        "<tr>
          <td>" . $wedstrijddeelname->wedstrijd->naam . "</td>
          <td>" .  divAnchor('', 'Bekijken', array('class' => 'resultaat', 'data-id' => $wedstrijddeelname->wedstrijd->naam)) ."</td>
        </tr>";
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
