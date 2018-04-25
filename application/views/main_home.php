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

    <!--Bootstrap datetimepicker script & style-->
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>resources/css/bootstrap-datetimepicker.min.css"/>

    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/stijl.css"/>
    <script type="text/javascript"
            src="http://localhost:8080/Wezenberg-Project/resources/js/moment-with-locales.js"></script>
    <script type="text/javascript"
            src="http://localhost:8080/Wezenberg-Project/resources/js/bootstrap-datetimepicker.min.js"></script>

    <title> <?php echo $titel; ?> </title>

    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>

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
            <?php echo anchor('Welcome/index', 'Wezenberg', 'class="navbar-brand"'); ?>
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
                    echo anchor('Welcome/wijzig/' . $persoon->id, 'Wijzig profiel');
                    echo '</li > ';
                    echo '<li> ';
                    echo anchor('Welcome/meldAf', 'Afmelden');
                    echo '</li > ';
                    echo '</ul > ';
                    echo '</li > ';
                } else {
                    echo '<li > ';
                    echo anchor('Welcome/logIn', 'Login');
                    echo ' </li > ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid main-container">
    <div class="col-md-12 content">
        <?php echo $inhoud; ?>
    </div>
</div>
<div id="footer">
    <footer>
        <?php echo $footer; ?>
    </footer>
</div>
</body>

</html>