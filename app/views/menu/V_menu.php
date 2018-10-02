<div id="container">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">CliMab</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class=""><a href="<?php echo base_url(); ?>">Accueil</a></li>
                    <?php if ($_SESSION["level"] === "3") { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gérer<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>Personnels/">Personnels</a></li>
                                <li><a href="<?php echo base_url(); ?>RessourcesMat/">Ressources Matérielles</a></li>
                                <li><a href="<?php echo base_url(); ?>Activites/">Activités</a></li>
                                <li><a href="<?php echo base_url(); ?>Parcours/">Parcours</a></li>
                                <li><a href="<?php echo base_url(); ?>PlanParcours/">Plan Parcours</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Patients<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>patient/creation">Création</a></li>
                            <li><a href="<?php echo base_url(); ?>patient/rechercher">Recherche</a></li>
                        </ul>
                    </li>
                    <?php if ($_SESSION["level"] == "3") { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Planification<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>Planning/planifier">Planification</a></li>
                                <li><a href="<?php echo base_url(); ?>Planning/creerJeuxDeDonnees">Créer jeu de données</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION["level"] != "3") { ?>
                        <li><a href="<?php echo base_url(); ?>Ressource/solo/<?php echo $_SESSION['id_individu']; ?>">Mon planning</a></li>
                    <?php } ?>
                    <li class=""><a href="<?php echo base_url(); ?>Auth/logout">Déconnexion</a></li>
                </ul>

            </div><!--/.nav-collapse -->
        </div>
    </nav>
</div>

