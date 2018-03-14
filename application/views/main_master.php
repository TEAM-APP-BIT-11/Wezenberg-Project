<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title> <?php echo $titel; ?> </title>



</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Wezenberg</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Team</a></li>
                <li><a href="#">Resultaten</a></li>
                <?php
                    if(isset($naam)){
                        echo '<li class="dropdown ">';
                        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $naam . '<span class="caret"></span></a>';
                        echo '<ul class="dropdown-menu" role="menu">';
                        echo '<li><a href="#">Logout</a></li>';
                        echo '</ul>';
                        echo '</li>';
                    } else{
                        echo '<li>';
                        echo anchor('welcome/toon', 'Login');
                        echo '</li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid main-container">
    <?php
        if(isset($menuGebruiker)){
            echo '<div class="col-md-2 sidebar">';
            echo '<ul class="nav nav-pills nav-stacked">';
            echo $menuGebruiker;
            echo '</ul>';
            echo '</div>';
        }
    ?>
    
    <div class="col-md-10 content">
        <?php echo $inhoud; ?>
    </div>

    <footer>
    </footer>

</div>

</body>

</html>