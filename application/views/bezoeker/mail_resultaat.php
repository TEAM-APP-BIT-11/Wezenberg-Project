<?php
/**
 * @file mail_resultaat.php
 * View waarin bezoeker wordt geinformeerd over het resultaat van zijn verstuurde bericht
 * - button met knop naar pagina waar bezoek was toen hij hij op contacteer klikte.
 */

?>


<h2>Uw bericht is <?php echo $resultaat; ?> verzonden</h2>
<hr class="colorgraph"/>

<p><?php echo   $melding ?></p>
<p>Ga terug naar de pagina waar u was door op onderstaande knop te klikken.</p>

<p> <?php echo anchor($naarPagina, 'Ga verder waar u was gebleven', 'class="btn btn-default"'); ?> </p>
