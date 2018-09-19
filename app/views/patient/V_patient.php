<?php
defined('BASEPATH') || exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">

        <title>Feuille de route</title>

        <!-- for mobile devices like android and iphone -->
        <meta content="True" name="HandheldFriendly" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <!-- CSS -->

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css">
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.datetimepicker.full.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jsapi"></script>
    </head>
    <header>
        <div id="container">
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class=""><a href="<?php echo base_url(); ?>Auth/logout">Déconnexion</a></li>
                        </ul>

                    </div><!--/.nav-collapse -->
                </div>
            </nav>
        </div>
    </header>
    <body>
        <div id="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Votre Planning : </h2>
                        <div class="jumbotron"> 
                            <table class="table table-striped">
                                <th>Nom de l'activité</th><th>Personnel médical</th><th>Heure début prévu</th><th>Heure fin prévu </th>
                                <?php
                                foreach ($activites as $row) {
                                    echo "<tr><td>" . $row["TXT_NOM"] . "</td>" .
                                    "<td>" . $row["ressNom"] . " " . $row["ressPrenom"] . "</td>" .
                                    "<td>" . date("H:i:s", strtotime($row["start"])) . "</td>" .
                                    "<td>" . date("H:i:s", strtotime($row["end"])) . "</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Informations</div>
                            <div class="panel-body">Les dates de début et fin de chaque activités peuvent être amené à changer.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>