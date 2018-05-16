<?php
/**
 * @file agenda.php
 *
 *
 * View waarin de agenda van de zwemmer wordt weergegeven.
 * - krijgt $innames-array binnen met datums waarop er een inname is.
 * - krijgt $datums-objecten binnen
 * - toont via FullCalendar.JS de agenda van de zwemmer
 * - haalt via Ajax supplementen binnen (toont deze in modal)
 * - haalt via Ajax locaties binnen (toont deze in modal)
 * @author Neil Van den Broeck
 */
?>


<script>
    function haalSupplementenOp(datum) {
        $.ajax({
            type: "GET",
            url: site_url + "/zwemmer/Agenda/haalAjaxOp_Innames",
            data: {
                datum: datum,
                persoonId:
                <?php echo $zwemmer->id; ?> },
            success: function (result) {
                $("#resultaat").html(result);
                $('#mijnDialoogscherm').modal('show');
            }
            ,
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        })
        ;
    }

    function haalLocatieOp(id) {
        $.ajax({
            type: "GET",
            url: site_url + "/zwemmer/Agenda/haalLocatieOp",
            data: {id: id},
            success: function (result) {
                console.log(result);
                $('#resultaatLocatie').html(result);
                $('#mijnLocatieScherm').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }


    $(document).ready(function () {
            $('#calendar').fullCalendar(
                {
                    //instellingen voor de fullCalendar-plugin
                    locale: "nl-be",
                    allDaySlot: false,
                    themeSystem: 'bootstrap3',
                    minTime: "6:00:00",
                    maxTime: "23:00:00",
                    slotLabelFormat: 'HH:mm',
                    slotLabelInterval: {hours: 1},
                    firstDay: 1,
                    //Innames knop in de headers krijgen voor elke dag waar er een inname voor is.
                    columnHeaderHtml: function (mom) {
                        var weergeven = "";
                        var innames = <?php echo $innames; ?>;
                        if ($.inArray(mom.format('YYYY-MM-DD').toString(), innames) != -1) {
                            weergeven += '<a href="#" class="supplementen btn btn-primary" data-datum=' + mom.format('YYYY-MM-DD') + '">Suppl.</a><br>';
                        }
                        return weergeven + mom.locale('nl-be').format("ddd DD MMM");
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

                    //evenementen in agenda stoppen.
                    events: <?php echo $datums; ?>,
                    //Bij het klikken op een evenement de juiste informatie in de modal stoppen en openen.
                    eventClick: function (calEvent) {
                        var begin = moment(calEvent.start.toString());
                        $('#begin').html(begin.utcOffset(0).format("DD/MM/YYYY HH:mm"));
                        var eind = moment(calEvent.end.toString());
                        $('#eind').html(eind.utcOffset(0).format("DD/MM/YYYY HH:mm"));
                        $('#titel').html(calEvent.title);
                        $('#locatie').html(calEvent.locatie).attr("data-id", calEvent.locatieId);
                        $('#extra').html(calEvent.description);
                        $('#mijnDetailscherm').modal('show');
                    }
                })
            ;

            //Bij het klikken op een supplement via ajax de supplementen ophalen en tonen in een bootstrap modal.
            $("body").on('click', '.btn.supplementen', (function (e) {
                    e.preventDefault();
                    var datum = $(this).data('datum');
                    haalSupplementenOp(datum);
                    var DateCreated = moment(datum, "YYYY-MM-DD");
                    $("#datum").html(DateCreated.format("DD/MM/YYYY"));

                })
            );

            //bij het klikken op een locatie van een evenement -> ajax voor locatie op te halen
            $("body").on('click', '#locatie', (function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    haalLocatieOp(id);
                })
            )
            ;

            //veranderen van de headers als er voor maandweergave wordt gekozen (dagen ipv datums)
            $("body").on('click', '.fc-month-button', function () {
                console.log("maand");
                $('.fc-day-header.fc-mon').html('Maandag');
                $('.fc-day-header.fc-tue').html('Dinsdag');
                $('.fc-day-header.fc-wed').html('Woensdag');
                $('.fc-day-header.fc-thu').html('Donderdag');
                $('.fc-day-header.fc-fri').html('Vrijdag');
                $('.fc-day-header.fc-sat').html('Zaterdag');
                $('.fc-day-header.fc-sun').html('Zondag');
            })
        }
    )
    ;

</script>

<h1>Agenda - <?php echo ucfirst($zwemmer->voornaam) . " " . ucwords($zwemmer->familienaam) ?></h1>

<div id="calendar">
</div>

<!-- Modal voor supplementen in weer te geven -->
<div class=" modal fade" id="mijnDialoogscherm" role="dialog">
    <div class="modal-dialog">
        <!-- Inhoud dialoogvenster-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Supplement(en) voor <span id="datum"></span></h4>
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

<!-- Modal om extra informatie over een evenement weer te geven -->
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
                        <td><a id="locatie"></a></td>
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

<!-- modal om extra informatie over de locatie weer te geven -->
<div class=" modal fade" id="mijnLocatieScherm" role="dialog">
    <div class="modal-dialog">
        <!-- Inhoud dialoogvenster-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span id="locatietitel"></span></h4>
            </div>
            <div class="modal-body">
                <p>
                <div id="resultaatLocatie"></div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
            </div>
        </div>

    </div>
</div>