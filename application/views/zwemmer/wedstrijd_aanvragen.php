<?php

/**
 * @file wedstrijd_aanvragen.php
 * View-pagina toon een dropdown met de mogelijke wedstrijden waarvoor er kan ingeschreven worden
 * Toont ook de status van de aanvraag.
 * @author Neil Van den Broeck
 */

?>

<script type="text/javascript">
    function haalReeksenop(wedstrijdId) {
        $.ajax({
            type: "GET",
            url: site_url + "/zwemmer/Wedstrijd/haalJsonOp_WedstrijdReeksen",
            data: {wedstrijdId: wedstrijdId},
            success: function (result) {
                try {
                    $('#resultaat').html("");
                    var wedstrijdreeksen = jQuery.parseJSON(result);
                    console.log("succes");
                    console.log(wedstrijdreeksen);
                    if (wedstrijdreeksen.length == 0) {
                        $("#info").html("Er zijn geen reeksen beschikbaar").show();
                    }
                    else {
                        for (var i = 0; i < wedstrijdreeksen.length; i++) {
                            var lijst = "<tr><td>" + wedstrijdreeksen[i].slag.naam +
                                "</td><td>" + wedstrijdreeksen[i].afstand.afstand +
                                "</td><td>" + wedstrijdreeksen[i].datum +
                                "</td><td>" + wedstrijdreeksen[i].beginuur +
                                "</td><td>";
                            //controleren of einduur bestaat of niet
                            if (wedstrijdreeksen[i].einduur == null) {
                                lijst += "/"
                            }
                            else {
                                lijst += wedstrijdreeksen[i].einduur
                            }
                            lijst += "</td>";

                            console.log(wedstrijdreeksen);
                            //geen deelname
                            if (wedstrijdreeksen[i].deelname == null) {
                                lijst += '<td><a class="btn btn-sm btn-success" href="' + site_url + '/zwemmer/Wedstrijd/schrijfIn/' + wedstrijdreeksen[i].id + '"> Schrijf in </a></td><td>Niet ingeschreven</td></tr>';
                            }
                            // wel deelname dus status tonen
                            else {
                                var disabled = "";
                                if (wedstrijdreeksen[i].deelname.status.id == 2 || wedstrijdreeksen[i].deelname.status.id == 3) {
                                    disabled = "disabled";
                                }
                                lijst += '<td><a class="btn btn-sm btn-danger ' + disabled + '" href="' + site_url + '/zwemmer/Wedstrijd/schrijfUit/' + wedstrijdreeksen[i].deelname.id + '">Schrijf uit</a></td>';
                                lijst += '<td class="' + wedstrijdreeksen[i].deelname.status.status.replace(/ /g, '') + '"> <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> ' + wedstrijdreeksen[i].deelname.status.status + '</td></tr>';
                            }

                            $('#resultaat').append(lijst);
                            $('#tabel').show();
                        }
                    }
                } catch (error) {
                    alert("--- ERROR IN JSON --" + result);
                }
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
            }
        });
    }

    //Bij wijzigen dropdown -> laden van de reeksen

    $(document).ready(function () {
        if ($('#wedstrijd').val() != "0") {
            haalReeksenop($('#wedstrijd').val());
        }
        $('#wedstrijd').change(function () {
            haalReeksenop($('#wedstrijd').val());
            //tabel niet weergeven bij wijziging in dropdown. evenals info-div
            $("#info, #tabel").hide();
        });
    })
    ;

</script>

<!-- CSS voor status weer te geven -->
<style type="text/css">

    .goedgekeurd {
        color: forestgreen;
    }

    .afgewezen {
        color: red;
    }

    .inafwachting {
        color: orange;
    }

</style>

<h1>Wedstrijd Aanvragen</h1>
<h3>Lijst van alle wedstrijden</h3>

<!-- $tonen is de variabele als er ingeschreven is dat deze metteen terug wordt getoont in de lijst -->
<?php echo form_dropdownpro("Wedstrijden", $wedstrijden, "id", "naam", $tonen, 'id="wedstrijd"'); ?>

<div id="info"></div>

<table id="tabel" class="table" style="display:none;">
    <thead>
    <th>Slag</th>
    <th>Afstand</th>
    <th>Datum</th>
    <th>Beginuur</th>
    <th>Einduur</th>
    <th>Aanvragen</th>
    <th>Status</th>
    <thead>
    <tbody id="resultaat">
    </tbody>
</table>
