<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">

        <title>Gestion Hopital de jour</title>

        <!-- for mobile devices like android and iphone -->
        <meta content="True" name="HandheldFriendly" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <!-- CSS -->

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/timeline.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/appTimeline.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/appDossierParcours.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/easycal.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.week-planner.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css" />    
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.datetimepicker.css" />
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.datetimepicker.full.js"></script>
    </head>
    <body>
        <!--<div class="container">
        <?php echo validation_errors(); ?>
    
        <?php echo form_open('../Auth'); ?>
    
            <h5>Identifiant</h5>
            <input type="text" name="username" value="" size="50" />
    
            <h5>Mot de passe</h5>
            <input type="password" name="password" value="" size="50" />
    
            <div><input type="submit" value="Submit" /></div>
    
            </form>
        </div>-->
        <div class="container-fluid" style="width: 500px;">
            <?php echo validation_errors(); ?>



            <?php echo form_open('../Auth'); ?>
            <h2 class="form-signin-heading">Se connecter</h2>
            <!--
                    <div  id="alertBad" class="alert alert-danger alert-dismissable" role="alert"> 
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    L'identifiant et le mot de passe ne correspondent pas.
                  </div>
                  <div  id="alertGood" class="alert alert-success alert-dismissable" role="alert">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    L'identifiant et le mot de passe sont corrects.
                  </div>
            -->

            <label for="inputId" class="sr-only">Identifiant</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Identifiant" required autofocus>
            <label for="inputPassword" class="sr-only">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
            <br/>
            <button  class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
        </form>


    </div> <!-- /container -->
</body>
</html>