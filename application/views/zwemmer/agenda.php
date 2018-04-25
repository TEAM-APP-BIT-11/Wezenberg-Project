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
                customButtons: {
                    myCustomButton: {
                        text: 'custom!',
                        click: function () {
                            alert('clicked the custom button!');
                        }
                    }
                },
                allDaySlot: false,
                themeSystem: 'bootstrap3',
                minTime: "6:00:00",
                maxTime: "23:00:00",
                slotLabelFormat: 'HH:mm',
                slotLabelInterval: {hours: 1},
                firstDay: 1,
                columnHeaderHtml: function (mom) {
                    var weergeven = "";
                    $.ajax({
                        type: "GET",
                        async: true,
                        url: site_url + "/zwemmer/Agenda/haalAjaxOp_Inname",
                        data:
                            {
                                datum: mom.format('YYYY-MM-DD')
                            }
                        ,
                        success: function (result) {
                            console.log(result);
                            if (result == "true") {
                                console.log("TRUE");
                                weergeven += '<a href="#" class="supplementen btn btn-primary" data-datum=' + mom.format('YYYY-MM-DD') + '">Suppl.</a><br>';
                            }
                        }
                        ,
                        error: function (xhr, status, error) {
                            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                        }
                    })
                    ;
                    return weergeven + mom.format('ddd DD/MM');

                    <!-- FOUTEN IN -->
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
                eventSources:
                    [
                        {
                            events: function (start, end, timezone, callback) {
                                $.ajax({
                                    url: site_url + "/zwemmer/Agenda/haalAjaxOp_AgendaItems",
                                    dataType: 'json',
                                    data: {
                                        // our hypothetical feed requires UNIX timestamps
                                        start: start.unix(),
                                        end: end.unix()
                                    },
                                    success: function (msg) {
                                        var events = msg.events;
                                        callback(events);
                                    }
                                });
                            }
                        },
                    ]
            })
        ;

        $("body").on('click', '.btn.supplementen', (function (e) {
            e.preventDefault();
            var datum = $(this).data('datum');
            haalSupplementenOp(datum);
            var DateCreated = new Date(Date.parse(datum));
            $("#datum").html(DateCreated.toLocaleDateString());
        }));
    })
    ;

</script>

<h1>Agenda</h1>
<a href="#" class="supplementen btn btn-primary" data-datum="2018-08-21">Supplementen</a>

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