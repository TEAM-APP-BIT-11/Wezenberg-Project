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
                    for (var i = 0; i < wedstrijdreeksen.length; i++) {
                        var lijst = "<tr><td>" + wedstrijdreeksen[i].slag.naam +
                            "</td><td>" + wedstrijdreeksen[i].afstand.afstand +
                            "</td><td>" + wedstrijdreeksen[i].datum +
                            "</td><td>" + wedstrijdreeksen[i].beginuur +
                            "</td>";

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


                    // HIER BEN IK BEZIG!
                } catch (error) {
                    alert("--- ERROR IN JSON --" + result);
                }
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        if ($('#wedstrijd').val() != "0") {
            haalReeksenop($('#wedstrijd').val());
        }
        $('#wedstrijd').change(function () {
            haalReeksenop($('#wedstrijd').val());
        });

    })
    ;

</script>

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

<?php
echo form_dropdownpro("Test", $wedstrijden, "id", "naam", $tonen, 'id="wedstrijd"'); ?>

<table id="tabel" class="table" style="display:none;">
    <thead>
    <th>Slag</th>
    <th>Afstand</th>
    <th>Datum</th>
    <th>Uur</th>
    <th>Aanvragen</th>
    <th>Status</th>
    <thead>
    <tbody id="resultaat">
    </tbody>


</table>
