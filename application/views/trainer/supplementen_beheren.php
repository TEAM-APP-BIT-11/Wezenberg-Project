<script type="text/javascript">
    
    function supplementenHalen(doelstellingId) {
        $.ajax({
            type: "GET",
            url: site_url + "/trainer/supplement/haalVoedingProducten",
            data: {doelstellingId: doelstellingId},
            success: function (result) {
                try {
                    var lijst = new Array()
                    var voedingen = jQuery.parseJSON(result);
                    
                    for (var i = 0; i < voedingen.length; i++) {
                        lijst.push("<option value=" + voedingen[i].id + ">"+ voedingen[i].naam +"</option>");
                                

                        
                    }
                        $('#supplementen').html(lijst);
                   
                        
                       
                       
                        
                   
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
        
        $('#doelstelling').change(function () {
            supplementenHalen($('#doelstelling').val());
        });

    })
    ;

</script>
<style>
    #supplementen{
        width:200px;
    }
    #doelstelling{
        width:200px;
    }
</style>



<form action="<?php echo site_url() ;?>/trainer/supplement/wijzigen" method="post">
    

<?php
$attributes = array('name' => 'formulier');
    echo form_open('trainer/supplement/wijzigen', $attributes);
echo "<h2>".$title."</h2>";
echo "<div>";
echo "<h3> Doelstelling Supplement:</h3>";
echo form_dropdownpro("doelstelling", $doelstellingen, "id", "doelstelling", 0, 'id="doelstelling" class="form-control"'); 
echo "</div>";


?>
    <div>
 <button class="btn btn-primary" name ="doelstellingen" type="submit" value="toevoegen" >toevoegen</button>   
<button class="btn btn-primary" name ="doelstellingen" type="submit" value="aanpassen">Aanpassen</button>
<button class="btn btn-primary" name ="doelstellingen" type="submit" value="verwijderen">verwijderen</button>  
    </div>
</form>
<form action="<?php echo site_url(); ?>/trainer/supplement/supplementVerandering" method="post">
    <div>
        <h3>Supplementen:</h3>
<select multiple id="supplementen" name="supplementen" class="form-control" >
    
</select>
        <button class="btn btn-primary" name ="supplement" type="submit" value="toevoegen" >toevoegen</button>   
<button class="btn btn-primary" name ="supplement" type="submit" value="aanpassen">Aanpassen</button>
<button class="btn btn-primary" name ="supplement" type="submit" value="verwijderen">verwijderen</button>  
    </div>  

</form> 



                        


