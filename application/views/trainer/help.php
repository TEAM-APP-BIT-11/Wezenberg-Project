<script>
$(document).ready(function(){
 $("#zoek").on("keyup", function() {
   var value = $(this).val().toLowerCase();
   $("div.panel-heading > h3").filter(function() {
     console.log($(this));
     $(this).closest('.panel').toggle($(this).text().toLowerCase().indexOf(value) > -1)
   });
 });
});
</script>



<h1>Zoeken</h1>
<div class="row">
  <div class="col-lg-4">
  <p>Type hier de functionaliteit die je wilt zoeken zoals bv. "Wedstrijd beheren".</p>
  <p>De pagina zal automatisch alles weergeven dat voldoet aan uw zoekopdracht.</p>
  <?php
  echo form_input(array('name' => 'zoek',
      'id' => 'zoek',
      'class' => 'form-control',
      'placeholder' => 'Wedstrijd beheren, Evenement en training beheren, Gebruikers beheren, ect.'));
   ?>
  </div>
</div>
<hr>

<div class="panel panel-default" id="wedstrijdBeheren">
  <div class="panel-heading">
    <h3 class="panel-title">Wedstrijden beheren</h3>
  </div>
  <div class="panel-body">
    <h3>Acties</h3>
    <h4>Op de wedstrijd beheren pagina kan je de volgende acties uitvoeren:</h4>
    <li>Toevoegen</li>
    <li>Aanpassen</li>
    <li>Verwijderen</li>
    <li>Reeks toevoegen</li>
    <?php echo toonAfbeelding('help/wedstrijdbeheren.png', 'class="img-responsive"'); ?>
    <hr>
    <h3>Wedstrijd Toevoegen</h3>
    <h4>Op de wedstrijd toevoegen pagina kan je een wedstrijd toevoegen</h4>
    <p>Vul de naam, begindatum, einddatum, kies de locatie en extra informatie van de nieuwe wedstrijd in.</p>
    <p>Klik op de toevoegen knop om de wedstrijd toe te voegen.</p>
    <p>Klik op de annuleren knop om terug te gaan naar wedstrijd beheren en geen wedstrijd toe te voegen.</p>
    <?php echo toonAfbeelding('help/wedstrijdtoevoegen.png', 'class="img-responsive"'); ?>
    <hr>
    <h3>Wedstrijd Aanpassen</h3>
    <h4>Op de wedstrijd aanpassen pagina kan je een bestaande wedstrijd aanpassen</h4>
    <p>Pas de naam, begindatum, einddatum,locatie en extra informatie aan van de wedstrijd.</p>
    <p>Klik op de opslaan knop om de aanpassingen op te slagen.</p>
    <p>Klik op de annuleren knop om terug te gaan naar wedstrijd beheren en geen aanpassingen op te slagen.</p>
    <h3>Reeks aanpassen of verwijderen</h3>
    <h4>Op de wedstrijd aanpassen pagina kan je een bestaande reeks aanpassen of verwijderen</h4>
    <p>Klik op de aanpassen knop om de reeks aan de passen.</p>
    <p>Klik op de verwijder knop om de reeks te verwijderen.</p>
    <hr>
    <?php echo toonAfbeelding('help/wedstrijdaanpassen.png', 'class="img-responsive"'); ?>
    <h3>Reeks toevoegen</h3>
    <h4>Op de reeks toevoegen pagina kan je een reeks toevoegen aan een bestaande wedstrijd</h4>
    <p>Vul de datum, beginuur, einduur, kies de afstand en slag van de reeks.</p>
    <p>Klik op de toevoegen knop om de reeks toe te voegen.</p>
    <p>Klik op de annuleren knop om terug te gaan naar wedstrijd beheren en reeks toe te voegen.</p>
    <?php echo toonAfbeelding('help/reekstoevoegen.png', 'class="img-responsive"'); ?>
  </div>
</div>



<?php  ?>
