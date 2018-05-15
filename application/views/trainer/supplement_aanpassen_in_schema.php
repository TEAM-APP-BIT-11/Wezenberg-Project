<?php
/**
 * @file supplement_trainer_toevoegen.php
 * @author Ruben Tuytens
 *
 * View waar een inname van een zwemmer wordt weergegeven en kan worden aangepast
 * - krijgt een $persoon-object binnen
 * - krijgt een $innames-object binnen
 * - krijgt een $inname-object binnen
 * - gebruikt jquery-datepicker
 */
?>


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script>
  var dates = new Array();


function addDate(date) {
    if (jQuery.inArray(date, dates) < 0) 
        dates.push(date);
}


// Takes a 1-digit number and inserts a zero before it
function padNumber(number) {
    var ret = new String(number);
    if (ret.length == 1) 
        ret = "0" + ret;
    return ret;
}

$.datepicker.regional['nl'] = {clearText: 'Effacer', clearStatus: '',
    closeText: 'sluiten', closeStatus: 'Onveranderd sluiten ',
    prevText: '<vorige', prevStatus: 'Zie de vorige maand',
    nextText: 'volgende>', nextStatus: 'Zie de volgende maand',
    currentText: 'Huidige', currentStatus: 'Bekijk de huidige maand',
    monthNames: ['januari','februari','maart','april','mei','juni',
    'juli','augustus','september','oktober','november','december'],
    monthNamesShort: ['jan','feb','mrt','apr','mei','jun',
    'jul','aug','sep','okt','nov','dec'],
    monthStatus: 'Bekijk een andere maand', yearStatus: 'Bekijk nog een jaar',
    weekHeader: 'Sm', weekStatus: '',
    dayNames: ['zondag','maandag','dinsdag','woensdag','donderdag','vrijdag','zaterdag'],
    dayNamesShort: ['zo', 'ma','di','wo','do','vr','za'],
    dayNamesMin: ['zo', 'ma','di','wo','do','vr','za'],
    dayStatus: 'Gebruik DD als de eerste dag van de week', dateStatus: 'Kies DD, MM d',
    
    initStatus: 'Kies een datum', isRTL: false};
$.datepicker.setDefaults($.datepicker.regional['nl']);
jQuery(function () {
    jQuery("#datepicker").datepicker({
         minDate:0,
        onSelect: function (dateText, inst) {
            dates =[];
            addDate(dateText);
            $("#datums").empty();
            $.each(dates, function(val, text){
                $('#datums').append($('<option></option>').val(text).html(text));
            })
            $('#datums option').prop('selected', true);
                
        },
        beforeShowDay: function (date) {
            var year = date.getFullYear();
            // months and days are inserted into the array in the form, e.g "01/01/2009", but here the format is "1/1/2009"
            var month = padNumber(date.getMonth() + 1);
            var day = padNumber(date.getDate());
            // This depends on the datepicker's date format
            var dateString = day + "/" + month + "/" + year;

            var gotDate = jQuery.inArray(dateString, dates);
            if (gotDate >= 0) {
                // Enable date so it can be deselected. Set style to be highlighted
                return [true, "ui-state-highlight"];
            }
            // Dates not in the array are left enabled, but with no extra style
            return [true, ""];
        }
    });
});
$(document).ready(function(){
    var datum = '<?php echo $inname->datum; ?>'.split('-');
    var test = datum[1] + "/"+ datum[2] + "/"+ datum[0]
    addDate(test);
     
   $.each(dates, function(val, text){
                $('#datums').append($('<option></option>').val(text).html(text));
            })
            $('#datums option').prop('selected', true);
   
   
})
  </script>
  
  <style>
      td {
          width:200px;
          padding:20px;
      }
      #datums{
         
          display: none;
      }
      
  </style>
  
      <?php
      $attributes = array('name' => 'supplementTrainerAanpassen', 'data-toggle' => 'validator', 'role' => 'form');
    echo form_open('trainer/supplementschema/aangepast', $attributes);
echo '<h2>'.$titel.'</h2>';
echo "<table>";
echo form_hidden('id', $inname->id);
echo form_hidden('innameReeksId', $inname->innameReeksId);
echo form_hidden('persoonId', $inname->persoonId);

echo "<tr> <td>";
echo form_label('Zwemmer', 'persoon');
echo "</td> <td>";
echo form_input('persoon',$persoon->voornaam . ' '. $persoon->familienaam, "disabled");
echo "</td> </tr>";



foreach($innames as $innam)
{
    $dropdown[$innam->id] = $innam->naam;
}
echo "<tr> <td>";
echo form_label('Supplementen:', 'supplementen');
echo "</td> <td>";
echo form_multiselect('supplementen', $dropdown, $inname->voedingssupplementId);
echo "</td><td>";
?>
    <form>
        <label name="datums">Kies de datum:</label>
    <input id="datepicker" name="datepicker" value="<?php echo date("m/d/Y",strtotime($inname->datum));?>" />
</form>
      
      <select multiple id="datums" name="datums[]"  >
          
      </select>
      
      
  <?php
  
  
echo "</td> </tr><tr> <td>";

echo form_label('Aantal 00x00 (aantal keren x aantal supp):', 'aantal');
echo "</td> <td>";


    echo '<div class="form-group">';
    echo form_input('aantal', $inname->aantal, 'class="form-control" data-error="Geef een aantal in de juiste vorm (bv. 000x000)" required pattern="[0-9]*[xX][0-9]*"');
    echo '<div class="help-block with-errors"></div>';
    echo '</div>';

echo "</td><td></td></tr>";
echo "</table>";

?>

      <button type="submit"name="aanpassen" id="aanpassen" class="btn btn-primary">Aanpassen</button>

<?php echo anchor('trainer/supplementschema/beheren', form_button('back', 'Annuleren', 'class="btn btn-primary"')) ;?>