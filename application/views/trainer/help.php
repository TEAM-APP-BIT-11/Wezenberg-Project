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

<style>
    img{
        width: 95%;
        border: 1px solid black;
        margin-top: 25px;
        margin-bottom: 25px;
    }
    .bold{
        font-weight: bold;
    }
</style>

<h1>Zoeken</h1>
<div class="row">
  <div class="col-lg-4">
  <p>Typ hier de functionaliteit die je wilt zoeken zoals bv. "Wedstrijden beheren".</p>
  <p>De pagina zal automatisch alles weergeven dat voldoet aan uw zoekopdracht.</p>
  <?php
  echo form_input(array('name' => 'zoek',
      'id' => 'zoek',
      'class' => 'form-control',
      'placeholder' => 'Wedstrijd beheren, Evenement en training beheren, Ect.'));
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
    <h3>Reeks toevoegen</h3>
    <h4>Op de reeks toevoegen pagina kan je een reeks toevoegen aan een bestaande wedstrijd</h4>
    <p>Vul de datum, beginuur, einduur, kies de afstand en slag van de reeks.</p>
    <p>Klik op de toevoegen knop om de reeks toe te voegen.</p>
    <p>Klik op de annuleren knop om terug te gaan naar wedstrijd beheren en reeks toe te voegen.</p>
    <hr>
  </div>
</div>

<div class="panel panel-default" id="evenementenBeheren">
  <div class="panel-heading">
    <h3 class="panel-title">Evenementen beheren</h3>
  </div>
  <div class="panel-body">
    <h3>Acties</h3>
    <h4>Op de evenementen beheren pagina krijg je een overzicht van alle evenementen dat gesorteerd is op het type van de evenementen. Elk type heeft een eigen tablad voor zijn overzicht.</h4>
    <li>Trainingen</li>
    <li>Medische testen</li>
    <li>Stages</li>
    <li>Overige evenementen</li>
    <?php echo toonAfbeelding('help/evenementenbeheren.png', 'class="img-responsive"'); ?>
    <hr>
    <h3>Evenement Toevoegen</h3>
    <h4>Op de evenementen toevoegen pagina kan je evenementen toevoegen</h4>
    <p class="bold">Enkel evenement</p>
    <p>Vul de gegevens van je evenement in om het aan te maken. Evenementnaam, datum, beginuur en locatie zijn hier verplichte velden. Je kan zwemmers aan het evenement toevoegen door in de lijst onderaan het formulier een zwemmer te selecteren en dan op het pijltje naar rechts te klikken. Alle deelnemende zwemmers krijgen het evenement in hun agenda te zien, en zullen ook een melding ontvangen dat het evenement aangemaakt is.</p>
    <p class="bold">Enkel evenement</p>
    <p>Als je een herhalend evenement wilt toevoegen selecteer je bij het veld "hoeveelheed" de optie "reeks". Je krijgt dan de mogelijkheid om een einddatum en de dagen waarop het evenement zal doorgaan te kiezen. Als je dit doet zal op elke geselecteerde dag tussen de begin- en einddatum een evenement aangemaakt worden.</p>
    <p>Klik op de knop opslaan om het evenement of de evenementreeks toe te voegen.</p>
    <p>Klik op de knop annuleren om terug te gaan naar evenementen beheren en geen evenement(en) toe te voegen.</p>
    <hr>
    <h3>Evenementen Aanpassen</h3>
    <h4>Op de evenement aanpassen pagina kan je bestaande evenementen aanpassen</h4>
    <p>Als je op de evenementen beheren pagina een evenement of een reeks selecteert en op bewerken klikt krijg je hetzelfde scherm te zien als wanneer je een evenement zou toevoegen maar dan zijn de velden reeds ingevuld met de informatie van het geselecteerde evenement. Je kan dan die informatie aanpassen.</p>
    <p>Klik op de opslaan knop om de aanpassingen op te slagen.</p>
    <p>Klik op de annuleren knop om terug te gaan naar evenementen beheren en geen aanpassingen op te slagen.</p>
    <h3>Evenementen verwijderen</h3>
    <h4>Op de evenementen beheren pagina kan je bestaande evenementen verwijderen</h4>
    <p>Om een evenement of een evenementreeks te verwijderen selecteer je op de evenementen beheren pagina wat je wilt verwijderen, en je klikt dan op de overeenkomende knop verwijderen knop om je selectie te verwijderen.</p>
    <hr>
  </div>
</div>

<div class="panel panel-default" id="gebruikersBeheren">
  <div class="panel-heading">
    <h3 class="panel-title">Gebruikers beheren</h3>
  </div>
  <div class="panel-body">
    <h3>Acties</h3>
    <h4>Op de gebruikers beheren pagina kan je de volgende acties uitvoeren:</h4>
    <li>Toevoegen</li>
    <li>Gegevens aanpassen</li>
    <li>Actief of inactief maken</li>
    <li>Verwijderen</li>
    <?php echo toonAfbeelding('help/gebruikersbeheren.png', 'class="img-responsive"'); ?>
    <hr>
    <h3>Gebruiker Toevoegen</h3>
    <h4>Op de gebruiker toevoegen pagina kan je een gebruiker toevoegen</h4>
    <p>Vul de velden in met de nodige informatie.</p>
    <p>Klik op de voeg toe knop om de gebruiker toe te voegen.</p>
    <p>Klik op de annuleren knop om de gebruiker niet toe te voegen.</p>
    <hr>
    <h3>Gegevens Aanpassen</h3>
    <h4>Op de gegevens aanpassen pagina kan je een gebruiker zijn gegevens aanpassen</h4>
    <p>Klik op de actief knop als je een gebruiker actief wilt maken.</p>
    <p>Klik op de inactief knop als je een gebruiker inactief wilt maken.</p>
    <hr>
    <h3>Actief Of Inactief Maken</h3>
    <h4>Op de gebruikers beheren pagina kan je een gebruik inactief of actief maken</h4>
    <p>Verander de velden waar je aanpassingen aan wilt maken.</p>
    <p>Klik op de oplsaan knop om de aanpassingen op te slagen.</p>
    <p>Klik op de annuleren knop om terug te gaan naar gebruikers beheren en geen aanpassingen op te slagen.</p>
    <hr>
  </div>
</div>

<div class="panel panel-default" id="startPaginaBeheren">
  <div class="panel-heading">
    <h3 class="panel-title">Startpagina beheren</h3>
  </div>
  <div class="panel-body">
    <h3>Acties</h3>
    <h4>Op de startpagine beheren pagina kan je de volgende acties uitvoeren:</h4>
    <li>Nieuwsitem toevoegen en aanpassen</li>
    <li>Kalender toevoegen en aanpassen</li>
    <hr>
    <h3>Nieuwsitem toevoegen en aanpassen</h3>
    <h4>Op de nieuwsitem toevoegen en aanpassen pagina kan je een nieuwitem toevoegen en aanpassen</h4>
    <p>Vul de velden in of verander ze met de nodige informatie.</p>
    <p>Klik op de oplsaan knop om het nieuwsitem op te slaan.</p>
    <p>Klik op de annuleren knop om het nieuwsitem niet op te slaan.</p>
    <hr>
    <h3>Kalender toevoegen en aanpassen</h3>
    <h4>Op de kalender toevoegen en aanpassen pagina kan je een evenement toevoegen en aanpassen</h4>
    <p>Vul de velden in of verander ze met de nodige informatie.</p>
    <p>Klik op de oplsaan knop om het evenement op te slaan.</p>
    <p>Klik op de annuleren knop om de evenement niet op te slaan.</p>
    <hr>
  </div>
</div>


<?php  ?>
