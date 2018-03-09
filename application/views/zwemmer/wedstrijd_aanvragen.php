<?php

$lijst = "";


foreach($wedstrijdreeksen as $wedstrijdreeks){
    $lijst .= "<tr><td>" . $wedstrijdreeks->slag->naam .
        "</td><td>" . $wedstrijdreeks->afstand->afstand .
        "</td><td>" . $wedstrijdreeks->datum .
        "</td><td>" . $wedstrijdreeks->beginuur .
        "</td><td>" . "XXX" .
        "</td><td>" . "XXX STATUS" . "</td></tr>";
}

?>

<h1>Wedstrijd Aanvragen</h1>
<h3>Lijst van alle wedstrijden</h3>

<?php echo form_dropdownpro("Test", $wedstrijden, "id", "naam"); ?>

<table class="table">
    <thead>
        <th>Slag</th>
        <th>Afstand</th>
        <th>Datum</th>
        <th>Uur</th>
        <th>Aanvragen</th>
        <th>Status</th>
    <thead>
    <tbody>
    <?php echo $lijst; ?>
    </tbody>
</table>
        