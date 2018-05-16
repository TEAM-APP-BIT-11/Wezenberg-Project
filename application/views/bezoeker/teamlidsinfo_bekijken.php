<h1 class="text-center">Mijn informatie</h1>
<div class="container-fluid well text-center">
    <div class="row-fluid">
        <?php echo toonAfbeelding('personen/' . $zwemmer->foto); ?>
        <h2><?php echo $zwemmer->voornaam . ' ' . $zwemmer->familienaam; ?></h2>
        <h3>Woonplaats: <?php echo $zwemmer->woonplaats; ?></h3>
        <h3>Geboortedatum: <?php echo zetOmNaarDDMMYYYY($zwemmer->geboortedatum); ?></h3>
        <h3>Biografie:</h3>
        <p><?php echo $zwemmer->biografie; ?></p>
        <?php echo anchor('bezoeker/Contact/zwemmer/' . $zwemmer->id, 'Contacteer me', 'class="btn btn-primary"'); ?>
    </div>
</div>
<a href=" javascript:history.go(-1);">
    <button type="button" class="btn btn-primary">Terug</button>
</a>
