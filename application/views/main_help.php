<?php
/**
 * @file main_help.php
 * 
 * Hoofdpagina voor de gebruikersondersteuning
 * - krijgt de variabelen $titel, $persoon, $inhoud en $footer binnen
 * - gebruikt Bootstrap navbar
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap 3.7 compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- jQuery minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Bootstrap 3.7 compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
            
            <!--JS confirmation plugin-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <link rel="icon" type="favicon" href="resources/img/favicon/zwemmer.png" />

    <title> <?php echo $titel; ?> </title>

    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>

    <base href="<?php echo base_url();?>" />

    <!--Bootstrap datetimepicker script & style-->
    <link rel="stylesheet" href="resources/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="resources/css/stijl.css"/>
    <script src="resources/js/moment-with-locales.js"></script>
    <script src="resources/js/bootstrap-datetimepicker.min.js"></script>

    <!--Agenda js en css-->
    <link rel="stylesheet" href="resources/css/fullcalendar.min.css"/>
    <script src="resources/js/moment.min.js"></script>
    <script src="resources/js/fullcalendar.min.js"></script>
    <script src="resources/js/gcal.js"></script>

</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php echo anchor('Algemeen/index', 'Wezenberg', 'class="navbar-brand"'); ?>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><?php echo anchor('bezoeker/Home/team', 'Team'); ?></li>
                <li><a href="#">Resultaten</a></li>
                <?php
                $persoon = $this->session->gebruiker;
                if ($persoon !== null) {
                    echo '<li class="dropdown ">';
                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . ucfirst($persoon->voornaam) . '<span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu" role="menu">';
                    echo '<li> ';
                    switch ($persoon->typePersoonId) {
                        case 1:
                            echo anchor('trainer/Home/', 'Home trainer');
                            break;
                        case 2:
                            echo anchor('zwemmer/Home/', 'Home zwemmer');
                            break;
                    }
                    echo '</li> ';
                    echo '<li> ';
                    echo anchor('Algemeen/wijzig/' . $persoon->id, 'Wijzig profiel');
                    echo '</li > ';
                    echo '<li> ';
                    echo anchor('Algemeen/meldAf', 'Afmelden');
                    echo '</li > ';
                    echo '</ul > ';
                    echo '</li > ';
                } else {
                    echo '<li > ';
                    echo anchor('Algemeen/logIn', 'Login');
                    echo ' </li > ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid main-container">
    <?php
    if ($persoon !== null) {
        echo '<div class="col-md-2 sidebar" > ';
        echo '<ul class="nav nav-pills nav-stacked" > ';
        if ($persoon->typePersoon->typePersoon == "trainer") {
            echo activeAnchor('trainer/help/#wedstrijdBeheren', 'Wedstrijden beheren');
            echo activeAnchor('trainer/help/#evenementenBeheren', 'Evenementen beheren', '');
            echo activeAnchor('trainer/help/#gebruikersBeheren', 'Gebruikers beheren', '');
            echo activeAnchor('trainer/help/#startPaginaBeheren', 'Startpagina beheren', '');
        } else {

            echo activeAnchor('zwemmer/Home', 'Nog geen help functie voor zwemmer', '');

        }
        echo '</ul > ';
        echo '</div > ';
    }
    ?>

    <div class="col-md-10 content">
        <?php echo $inhoud; ?>
    </div>


</div>
<footer>
    <?php echo $footer; ?>
</footer>
</body>

</html>
