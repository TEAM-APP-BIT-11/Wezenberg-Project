<?php
$attributen = array('name' => 'mijnFormulier');
echo form_open('welcome/registreer', $attributen);
echo form_hidden('id', $persoon->id);
?>
<h1>Profiel beheren</h1>
<?php echo "<h3>" . $persoon->voornaam . " " . $persoon->familienaam . "</h3>" ?>
<table>
    <tr>
        <td><?php echo form_label('Voornaam:', 'bedrijf'); ?></td>
        <td><?php echo form_input('voornaam', $persoon->voornaam, 'size=50'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Familienaam:', 'familienaam'); ?></td>
        <td><?php echo form_input('familienaam', $persoon->familienaam, 'size=50'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Straat:', 'straat'); ?></td>
        <td><?php echo form_input('straat', $persoon->straat, 'size=50'); ?></td>
        <td><?php echo form_label('Nummer:', 'nummer'); ?></td>
        <td><?php echo form_input('nummer', $persoon->nummer, 'size=10'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('E-mailadres:', 'mailadres'); ?></td>
        <td><?php echo form_input('mailadres', $persoon->mailadres, 'size=50'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Telefoonnummer:', 'gsmnummer'); ?></td>
        <td><?php echo form_input('gsmnummer', $persoon->gsmnummer, 'size=50'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Gemeente:', 'gemeente'); ?></td>
        <td><?php echo form_input('gemeente', $persoon->woonplaats, 'size=50'); ?></td>
        <td><?php echo form_label('Postcode:', 'postcode'); ?></td>
        <td><?php echo form_input('postcode', $persoon->postcode, 'size=10'); ?></td>
    </tr>
    <tr>
        <td><?php echo form_label('Biografie:', 'biografie'); ?></td>
        <td><?php echo form_input('biografie', $persoon->biografie, 'size=50', 'height= 25'); ?></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo form_submit('knop', 'Wijzig'); ?></td>
    </tr>
</table>

<?php echo form_close(); ?>

<p><?php echo anchor('welcome/index', "Back"); ?></p>



