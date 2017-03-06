<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/background-login.css">
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        .input-field .prefix.active {
            color: #1976d2 ;
        }
        .input-field input[type=text]:focus + label, 
        .input-field input[type=password]:focus + label {
            color: #1976d2;
        }
       .input-field input[type=text]:focus,
       .input-field input[type=password]:focus {
            border-bottom: 4px solid #1976d2;
            box-shadow: 0 0px 0 0 #1976d2;
        }
        hr {
            border-color:#1976d2;
        }
        h1 {
            cursor: context-menu;
        }

    </style>

    <title><?php echo $page_title; ?></title>
</head>
<body class='grey darken-4'>

    <div class="container" id='login_form'>
        <div class="row">
            <div class="col m6 offset-m3 s6 offset-s3">
                <h1 class='white-text'>Login</h1>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col l4 offset-l4 m4 offset-m4 s6 offset-s3">
                <form method="post" action="check_login" autocomplete="off">
                    <div class="row">
                        <div class="input-field">
                            <input name="username" id="username" type="text" class="validate white-text" required>
                            <label for="username">Usuario</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <input name="password" id="password" type="password" class="validate white-text" required autocomplete="new-password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                    <button class="btn waves-effect waves-light blue darken-2" type="submit" name="action">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
        
    <!--Import jQuery before materialize.js-->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            Materialize.updateTextFields();
        });
    </script>
</body>
</html>