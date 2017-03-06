<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title><?php echo 'TV Track - '.$page_title; ?></title>
</head>
<body>
    <!--Import jQuery before materialize.js-->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".button-collapse").sideNav();
        });
    </script>

    <nav class="blue darken-2">
        <div class="nav-wrapper">
            <a href="main" class="brand-logo center">TV Track</a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="left hide-on-med-and-down">
                <li><a href="following">Siguiendo</a></li>
                <li><a href="series">Series</a></li>
            </ul>
            <ul class="side-nav" id="mobile-demo">
                <li><a href="following">Siguiendo</a></li>
                <li><a href="series">Series</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">