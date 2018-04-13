<script>
    
    function wachtwoordCorrect(nieuwWW)
    {
        $.ajax({type : "GET",
                url : site_url + "/trainer/wedstrijd/" ,
                data : {reeksId : reeksId},
                success : function(){
                    $("#success").show();
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
        });

    }

    $(document).ready(function () {
        
        $(".formResultaten").hide();
        $(".btnOpslaan").hide();
        
        $('#reeks').change(function() {
                     
            var e = document.getElementById("reeks");
            var reeksId = e.options[e.selectedIndex].value;
            var reeks = e.options[e.selectedIndex].text;
    
            if (reeksId != 0)
            {
                $('#reeksTitel').html(reeks)
                $(".formResultaten").show();
                $(".btnOpslaan").show();
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

        <h5>Finale</h5>

        <table class="table">
            <tr class="active">
                <td>Ranking</td>
                <td>Zwemmer</td>
                <td>Resultaat</td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
        </table>

        <h5>Halve finale</h5>

        <table class="table">
            <tr class="active">
                <td>Ranking</td>
                <td>Zwemmer</td>
                <td>Resultaat</td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
        </table>

        <h5>Voorronden</h5>

        <table class="table">
            <tr class="active">
                <td>Ranking</td>
                <td>Zwemmer</td>
                <td>Resultaat</td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>XXXX</td>
                <td></td>
            </tr>
        </table>

        
    </div>
    
    <div class="col-md-8 coll-md-offset-2 ">
        <p><?php 

        echo anchor('/trainer/Wedstrijd/resultaten', 'Annuleren', 'class="btn btn-primary"'); 

    
        
        echo anchor('/trainer/Wedstrijd/resultaten', 'Opslaan', 'class="btn btn-default btnOpslaan"')
                ?>
        
        </p>
    </div>
</div>