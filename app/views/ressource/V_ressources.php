<div class="container-fluid">
    <div class="jumbotron">
        <h3> Toutes les ressources de l'hopital </h3>
        <a href="<?php echo base_url(); ?>RessourcesMat/ajout/">Ajouter une ressource</a>
        <table name="formu"class="table table-responsive table-hover">
            <thead>         
                <tr>
                    <th class="col-xs-5">NOM</th>
                    <th class="col-xs-5">Spécialité</th>
                    <th class="col-xs-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($ressources as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row["txt_nom"] ?></td>
                        <td><?php echo $row["type"] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span><span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo base_url(); ?>RessourcesMat/modif/<?php echo $row["id_salle"] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modifier</a></li>
                                    <li><a href="<?php echo base_url(); ?>RessourcesMat/suppr/<?php echo $row["id_salle"] ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a></li>
                                </ul>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>
