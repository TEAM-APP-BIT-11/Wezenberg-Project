<div class="row text-center">
<h2 class="text-center">Zwemmers</h2>
<?php
$lijstzwemmers = "";
foreach ($zwemmers as $zwemmer) {

  echo    '<div class="col-md-4">';
  echo      '<div class="thumbnail">';
  echo        '<img src="http://via.placeholder.com/250x250" alt="' .$zwemmer->voornaam . '">';
  echo        '<div class="caption">';
  echo          '<h3>' .$zwemmer->voornaam . ' ' . $zwemmer->familienaam . '</h3>';
  echo          '<p>' . anchor('bezoeker/Home/zwemmer/' . $zwemmer->id, 'Meer info', 'class="btn btn-primary"') . '</p>';
  echo        '</div>';
  echo      '</div>';
  echo    '</div>';
}
?>
</div>
<a href="javascript:history.go(-1);"><button type="button" class="btn btn-secundary">Terug</button></a>
