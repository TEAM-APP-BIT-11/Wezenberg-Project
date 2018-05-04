<script>
    
    function haalResultatenOp(reeksId)
    {
        $.ajax({type : "GET",
                url : site_url + "/trainer/wedstrijdresultaat/resultatenOphalen" ,
                data : {reeksId : reeksId},
                success: function (result) {
                $("#success").html(result);
            },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
        });

    }

    $(document).ready(function () {
        
        $(".formResultaten").hide();
        $(".btnToevoegen").hide();
        $("#success").hide();
        
        $('#reeks').change(function() {
                     
            var e = document.getElementById("reeks");
            var reeksId = e.options[e.selectedIndex].value;
            var reeks = e.options[e.selectedIndex].text;
    
            if (reeksId != 0)
            {
                $('#reeksTitel').html(reeks)
                haalResultatenOp(reeksId);
                $(".formResultaten").show();
                $("#success").show();
                $(".btnToevoegen").show();
                $(".btnToevoegen").attr('href', '../../../trainer/wedstrijdresultaat/toevoegen/' + reeksId);
            }
        });
        
    });

</script>

<style>
    .btnOpslaan{
        margin-left: 5px;
    }
    
    .form-group{
        margin-left: 0px;
        width: 200px;;
    }
</style>

<h1 class="">Resultaten <?php echo $wedstrijd->naam ?></h1>
<div class="row">
    <div class="col-md-8 coll-md-offset-2">
        
        <div class="form-group">
            <label for="reeks">Kies een reeks:</label>
            
            <select id="reeks" name="deelnemendeZwemmers" class="form-control" size="<?php echo count($zwemmers);?>">
                <?php
                
                echo '<option class="option" value="0">Kies een reeks</option>';
                                
                foreach ($reeksen as $reeks) {
                    
                    echo '<option class="option" value="' . $reeks->id . '">' . $reeks->slag->naam . " - " . $reeks->afstand->afstand . " meter </option>";
                    
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-8 coll-md-offset-2 formResultaten">
        <h3 id="reeksTitel">hehe</h3>

        

        
    </div>
    
    <div id="success" class="col-md-8 coll-md-offset-2">
        
    </div>
    
    <div class="col-md-8 coll-md-offset-2 ">
        <p><?php 

        echo anchor('/trainer/Wedstrijdresultaat/resultaten', 'Annuleren', 'class="btn btn-primary"');
        

                ?>
            
            <a class="btn btn-default btnToevoegen">Resultaat toevoegen</a>
        
        </p>
    </div>
    
</div>