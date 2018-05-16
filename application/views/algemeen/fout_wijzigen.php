<?php
$attributes = array('name' => 'mijnFormulier', 'class' => 'form-signin');
echo form_open('Algemeen/controleerAanmelden', $attributes);
?>
<div class="wrapper">
    <h2 class="form-signin-heading">Oeps!</h2>
    <hr class="colorgraph">
    <div class="panel panel-danger">
        <div class="panel-body">
            <p class="text-danger">  <?php echo $error; ?> </p>
        </div>
    </div>
    <br>
   
</div>
