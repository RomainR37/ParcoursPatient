<div class="container-fluid">
    <div class="jumbotron">
        <table name="formu"class="table table-responsive table-hover">
            <thead>         
                <tr>
                    <th class="col-xs-2">Nom</th>
                    <th class="col-xs-3">Prénom</th>
                    <th class="col-xs-2">Date de naissance</th>
                    <th class="col-xs-3">Numéro de sécurité sociale</th>
                    <th class="col-xs-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($patients as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row["TXT_NOM"] ?></td>
                        <td><?php echo $row["TXT_PRENOM"] ?></td>
                        <td><?php echo $row["DATE_NAISSANCE"] ?></td>
                        <td><?php echo $row["TXT_NUMSECU"] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span><span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo base_url(); ?>Patient/modifierPatient/<?php echo $row["ID_PATIENT"] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modifier patient</a></li>
                                    <li><a href="<?php echo base_url(); ?>Patient/gererRDV/<?php echo $row["ID_PATIENT"] ;?>"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> Gérer RDV</a></li>
                                    <li><a href="<?php echo base_url(); ?>Patient/afficherSejour/<?php echo $row["ID_PATIENT"] ?>"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Afficher planning</a></li>
                                    <li><a href="<?php echo base_url(); ?>DossierParcours/dossier/<?php echo $row["ID_PATIENT"] ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Consulter Dossier parcours</a></li>
                                    <li><a href="<?php echo base_url(); ?>Patient/supprimer/<?php echo $row["ID_PATIENT"] ?> "><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer patient</a></li>
                              
                                </ul>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>





