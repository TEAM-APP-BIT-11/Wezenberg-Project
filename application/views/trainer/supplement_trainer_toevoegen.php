<?php
/**
 * @file supplement_trainer_toevoegen.php
 * @author Ruben Tuytens
 *
 * View waar een nieuwe inname kan worden toegevoegd voor een zwemmer
 * - krijgt een $personen-object binnen
 * - krijgt een $innames-object binnen
 * - gebruikt jquery-datepicker
 */

?>


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/trunk/ui/i18n/jquery.ui.datepicker-nl.js"></script>
<script>
      
    

  var dates = new Array();

function addDate(date) {
    
    
   
    
    if (jQuery.inArray(date, dates) < 0) 
     
        dates.push(date);
}

function removeDate(index) {
    dates.splice(index, 1);
}

// Adds a date if we don't have it yet, else remove it
function addOrRemoveDate(date) {
    var index = jQuery.inArray(date, dates);
    
        if (index >= 0) 
        removeDate(index);
    else 
 
           addDate(date);  
        
            
   
       
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
        
       language: 'nl',
       minDate:0,
        onSelect: function (dateText, inst) {
        
         
               addOrRemoveDate(dateText);


             
              
                
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
            var dateString = month + "/" + day + "/" + year;

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

  </script>
  <style>
      td {
          width:200px;
          padding:20px;
      }
      #datums{
          
          width:150px;
      }
      
  </style>
  
  
   <?php $attributes = array('name' => 'supplementTrainerToevoegen', 'data-toggle' => 'validator', 'role' => 'form');
    echo form_open('trainer/supplementschema/opslaan', $attributes);
    ?>
  
      <?php

echo "<h2>".$titel."</h2>";
echo "<table>";
$options[0]= '-- Selecteer --';
foreach($personen as $persoon)
{
    if($persoon->typePersoonId == 2)
    {
        $options[$persoon->id] = $persoon->voornaam . ' ' . $persoon->familienaam;
    }
  
}
echo "<tr> <td>";
echo form_label('Zwemmer:', 'personen');
echo "</td> <td>";
echo form_dropdown('personen', $options, '' ,'required="required"');
echo "</td></tr>";


foreach($innames as $inname)
{
    $dropdown[$inname->id] = $inname->naam;
}
echo "<tr> <td>";
echo form_label('Supplementen:', 'supplementen');
echo "</td> <td>";
 echo '<div class="form-group">';
echo form_multiselect('supplementen', $dropdown, '','class="form-control" data-error="Supplement selecteren" required');
 echo '<div class="help-block with-errors"></div>';
    echo '</div>';
echo '</td><td >';
?>

      <label name="datepicker">Kies je datums:</label>  
        <input id="datepicker" name="datepicker"  required  />
  
        <label name="datums">Geselecteerde datums:</label>
      <select multiple id="datums" name="datums[]"   >
          
      </select>
            


  <?php
  
  
echo "</td> </tr><tr> <td>";

echo form_label('Aantal 00x00 (aantal keren x aantal supp):', 'aantal');
echo "</td> <td>";


    echo '<div class="form-group">';
    echo form_input('aantal', '', 'class="form-control" data-error="Geef een aantal in de juiste vorm (bv. 000x000)" required pattern="[0-9]*[xX][0-9]*"');
    echo '<div class="help-block with-errors"></div>';
    echo '</div>';

echo "</td><td></td></tr>";
echo "</table>";

?>
         </div>
      <button type="submit"name="toevoegen" id="toevoegen" class="btn btn-primary">Toevoegen</button>

<?php echo anchor('trainer/supplementschema/beheren', form_button('back', 'annuleren', 'class="btn btn-primary"')) ;?>