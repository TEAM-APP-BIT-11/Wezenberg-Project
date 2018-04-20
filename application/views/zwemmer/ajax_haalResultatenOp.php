<table class="table">
            <tr class="active">
                <td><label for="type">Ronde</label></td>
                <td><label for="type">Tijd</label></td>
                <td><label for="type">Ranking</label></td>
            </tr>


<?php

    foreach($wedstrijdreeksen as $wedstrijdreeks)
    {
        echo "<tr><td> " . $wedstrijdreeks->slag->naam . "</td>";
        // echo "<td> " . $wedstrijdreeks->resultaat->tijd . "</td>";
        // echo "<td> " . $wedstrijdreeks->ranking->ranking . "</td>";
    }

?>
</table>
