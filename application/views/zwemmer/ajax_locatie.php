<table class="table">
    <tr>
        <td>Locatie</td>
        <td><span id="locatie"><?php echo $locatie->naam ?></span></td>
    </tr>
    <tr>
        <td>Straat & nummer</td>
        <td><span id="straat"><?php echo $locatie->straat . " " . $locatie->nr ?></span></td>
    </tr>
    <tr>
        <td>Gemeente</td>
        <td><span id="gemeente"><?php echo $locatie->postcode . " " . $locatie->gemeente ?></span></td>
    </tr>
    <tr>
        <td>Land</td>
        <td><span id="land"><?php echo $locatie->land ?></span></td>
    </tr>

    <tr>
        <td>Zaal</td>
        <td><span id="zaal"><?php echo $locatie->zaal ?></span></td>
    </tr>

    <tr>
        <td>Extra info</td>
        <td><span id="info"><?php echo $locatie->extraInfo ?></span></td>
    </tr>

</table>