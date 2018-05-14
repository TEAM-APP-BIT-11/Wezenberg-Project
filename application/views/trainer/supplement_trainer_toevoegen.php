<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
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

jQuery(function () {
    jQuery("#datepicker").datepicker({
      
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

echo "<h2>".$title."</h2>";
echo "<table>";
$options[0]= '-- Select --';
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

echo form_label('Aantal:', 'aantal');
echo "</td> <td>";


    echo '<div class="form-group">';
    echo form_input('aantal', '', 'class="form-control" data-error="Geef een aantal" required');
    echo '<div class="help-block with-errors"></div>';
    echo '</div>';

echo "</td><td></td></tr>";
echo "</table>";

?>
         </div>
      <button type="submit"name="toevoegen" id="toevoegen" class="btn btn-primary">Toevoegen</button>

<?php echo anchor('trainer/supplementschema/beheren', form_button('back', 'annuleren', 'class="btn btn-primary"')) ;?>