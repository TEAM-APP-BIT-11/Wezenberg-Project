<h1><?php echo $zwemmer->voornaam; ?></h1>

<h3>Algemene Informatie</h3>
<ul>
    <li><?php echo $zwemmer->voornaam . ' ' . $zwemmer->familienaam; ?></li>
    <li><?php echo $zwemmer->woonplaats; ?></li>
    <li><?php echo zetOmNaarDDMMYYYY($zwemmer->geboortedatum); ?></li>
</ul>

<h2>NOG INFORMATIE</h2>

<?php echo anchor('bezoeker/Contact/zwemmer/' . $zwemmer->id, 'Contacteer me', 'class="btn btn-primary"'); ?>