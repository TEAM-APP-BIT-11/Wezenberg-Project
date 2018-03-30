<script>

    function haalSupplementenOp(datum) {
        // hier vervolledigen (oef 3b)
        $.ajax({
            type: "GET",
            url: site_url + "/zwemmer/Agenda/haalAjaxOp_Innames",
            data: {datum: datum},
            success: function (result) {
                $("#resultaat").html(result);
                $('#mijnDialoogscherm').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {

        $(".btn").click(function (e) {
            e.preventDefault();
            var datum = $(this).data('datum');
            haalSupplementenOp(datum);
            $("#datum").html();
        });

    });

</script>

<h1>Agenda</h1>
<a href="#" class="btn btn-primary" data-datum="2018-08-21">Supplementen</a>

<?php

echo '<table class="table">'
    . '<thead><tr><th>Uur</th><th>Maandag</th><th>Dinsdag</th><th>Woensdag</th><th>Donderdag</th><th>Vrijdag</th><th>Zaterdag</th><th>Zondag</th></thead>'
    . '<tbody>';
for ($x = 0; $x <= 21; $x++) {
    echo "<tr><td>" . $x . ":00</td>";
    for ($y = 0; $y <= 6; $y++) {
        echo "<td>test</td>";
    }
    echo '</tr>';
}

echo '</tbody></table>';

?>

<div class=" modal fade" id="mijnDialoogscherm" role="dialog">
    <div class="modal-dialog">
        <!-- Inhoud dialoogvenster-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Supplementen: <span id="datum"></span></h4>
            </div>
            <div class="modal-body">
                <p>
                <div id="resultaat"></div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
            </div>
        </div>

    </div>
</div>