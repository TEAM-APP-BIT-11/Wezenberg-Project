<table class="table">
            <tr class="active">
                <td><label for="type">Ronde</label></td>
                <td><label for="type">Tijd</label></td>
                <td><label for="type">Resultaat</label></td>
            </tr>


<?php

    foreach($wedstrijddeelnames as $wedstrijddeelname)
    {
        echo "<tr><td> " . $wedstrijddeelname->resultaat->rondetype->type . "</td>";
        echo "<td> " . $wedstrijddeelname->resultaat->tijd . "</td>";
        echo "<td> " . $wedstrijddeelname->resultaat->ranking . "</td>";
    }
?>
</table>
