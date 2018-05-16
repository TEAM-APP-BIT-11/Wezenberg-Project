<?php
/**
 * @file wedstrijdaanvraag_aanpassen.php
 * @author Ruben Tuytens
 *
 * View waar een wedstrijddeelname wordt weergegeven van een persoon en kan aangepast worden.
 * - krijgt een $deelname-object binnen
 * - krijgt een $huidigeSlagAFstand-object binnen
 * - haalt afstanden op met ajax
 */
?>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script>
    
    
    function afstandenHalen(slagId, wedstrijdId, wedstrijdReeksId, persoonId) {
        $.ajax({
            type: "GET",
            url: site_url + "/trainer/wedstrijdaanvraag/haalSlagenAfstand",
            data: {slagId: slagId, wedstrijdId: wedstrijdId, wedstrijdReeksId: wedstrijdReeksId, persoonId: persoonId},
            success: function (result) {
                try {
                    var lijst = new Array();
                    var afstanden = jQuery.parseJSON(result);
                  //  var slag = $('[name="slag"]').val();
                    for (var i = 0; i < afstanden.length; i++) {
                        
                  
                        lijst.push("<option value=" + afstanden[i].afstand.id + ">"+ afstanden[i].afstand.afstand +"</option>");    
                     
                        
                            
                        
                                
    
                        
                    }  
                        $('[name="afstand"]').html(lijst);
                        $('[name="reeksId"]').val(lijst);
                       
                       
                       
                        
                   
                } catch (error) {
                    alert("--- ERROR IN JSON --" + result);
                }
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
            }
        });
    }
   
    $(document).ready(function () {
          
        $('[name="afstand"').hide();
        
        $('[name="slag"]').change(function () {
            $('[name="afstand"').show();
          
          
            afstandenHalen($('[name="slag"]').val(), $('[name="wedstrijdId"]').val(), <?php echo $huidigeSlagAfstand->id;?>, <?php echo $deelname->persoon->id;?> );
        });

    })
    ;

</script>

<?php
echo '<h2>'.$titel.'</h2>';
echo '<h3>Wedstrijd: '.$deelname->wedstrijd->naam .'</h3>';
echo '<h4>Zwemmer: '.$deelname->persoon->voornaam.'</h4>';
echo '<h4>Huide wedstrijdaanvraag '.$huidigeSlagAfstand->slag->naam . ' '. $huidigeSlagAfstand->afstand->afstand .'m</h4>';?>
<form action="<?php echo site_url() ;?>/trainer/wedstrijdaanvraag/aanpassen" method="post">
<?php
echo form_hidden('wedstrijdId', $deelname->wedstrijd->id);
echo form_hidden('persoonId', $deelname->persoon->id);
echo form_hidden('deelnameId', $deelname->id);
echo form_hidden('statusId', $deelname->statusId);
echo form_label('Verschillende slagen', 'slagen');

echo '</br>';
$options[0]= '-- Selecteer --';
foreach($deelname->reeksen as $reeks)
{
    
        $options[$reeks->slagId] = $reeks->slag->naam;
    
  
}
echo form_hidden('reeksId');
echo "<tr> <td>";
echo form_label('Slag:', 'slag');
echo "</td> <td>";
echo form_dropdown('slag', $options, '' ,'class="form-control"');
echo "</td></tr>";


echo "<tr> <td>";
echo form_label('Afstand:', 'afstand');
echo "</td> <td>";
echo form_dropdown('afstand', '', '' ,'class="form-control"');



echo "</td></tr></br>";



?>
    
<button name ="aanpassen" type="submit" value="submit" class="btn btn-primary">Aanpassen</button>
<?php echo anchor('trainer/wedstrijdaanvraag/beheren', form_button('back', 'Annuleren', 'class="btn btn-primary"')) ;?>
