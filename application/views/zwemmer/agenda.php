<?php
/**
 * @file agenda.php
 *
 * View waarin de agenda van de zwemmer wordt weergegeven.
 * - krijgt $innames-array binnen met datums waarop er een inname is.
 * - krijgt $datums-objecten binnen
 * - toont via FullCalendar.JS de agenda van de zwemmer
 * - haalt via Ajax supplementen binnen
 */
?>


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
        $('#calendar').fullCalendar(
            {
                allDaySlot: false,
                themeSystem: 'bootstrap3',
                minTime: "6:00:00",
                maxTime: "23:00:00",
                slotLabelFormat: 'HH:mm',
                slotLabelInterval: {hours: 1},
                firstDay: 1,
                columnHeaderHtml: function (mom) {
                    var weergeven = "";
                    var innames = <?php echo $innames; ?>;
                    if ($.inArray(mom.format('YYYY-MM-DD').toString(), innames) != -1) {
                        weergeven += '<a href="#" class="supplementen btn btn-primary" data-datum=' + mom.format('YYYY-MM-DD') + '">Suppl.</a><br>';
                    }
                    return weergeven + mom.format("ddd DD / MM");

                },
                header:
                    {
                        left: 'prev,next today myCustomButton',
                        center:
                            'title',
                        right:
                            'month,agendaWeek,agendaDay'
                    }
                ,
                defaultView: 'agendaWeek',
                nowIndicator:
                    'True',

                events: <?php echo $datums; ?>,
                eventClick: function (calEvent) {
                    var begin = moment(calEvent.start.toString());
                    $('#begin').html(begin.utcOffset(0).format("DD/MM/YYYY HH:mm"));
                    var eind = moment(calEvent.end.toString());
                    $('#eind').html(eind.utcOffset(0).format("DD/MM/YYYY HH:mm"));
                    $('#titel').html(calEvent.title);
                    $('#locatie').html(calEvent.locatie);
                    $('#extra').html(calEvent.description);
                    $('#mijnDetailscherm').modal('show');
                }
            })
        ;

        $("body").on('click', '.btn.supplementen', (function (e) {
                e.preventDefault();
                var datum = $(this).data('datum');
                haalSupplementenOp(datum);
                var DateCreated = moment(Date.parse(datum));
                $("#datum").html(DateCreated.format("MM-DD-YYYY"));

            })
        )
        ;
    })
    ;

</script>

<h1>Agenda</h1>

<div id="calendar">
</div>

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

<div class=" modal fade" id="mijnDetailscherm" role="dialog">
    <div class="modal-dialog">
        <!-- Inhoud dialoogvenster-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span id="titel"></span></h4>
            </div>
            <div class="modal-body">
                <p>
                <table class="table">
                    <tr>
                        <td>Begindatum</td>
                        <td><span id="begin"></span></td>
                    </tr>
                    <tr>
                        <td>Einddatum</td>
                        <td><span id="eind"></span></td>
                    </tr>
                    <tr>
                        <td>Extra</td>
                        <td><span id="extra"></span></td>
                    </tr>
                    <tr>
                        <td>Locatie</td>
                        <td><span id="locatie"></span></td>
                    </tr>


                </table>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
            </div>
        </div>

    </div>
</div>