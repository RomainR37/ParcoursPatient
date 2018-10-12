<div class="container-fluid">
    <div class="jumbotron">
        <h3> Parcours-patient au sein de l'hôpital </h3>
        <a href="<?php echo base_url('Parcours/ajout/') ?>">Ajouter un parcours-patient</a>
        <table name="formu"class="table table-responsive table-hover">
            <thead>         
            <th class="col-xs-3">Nom du parcours</th>
            <th class="col-xs-1">Code</th>
            <th class="col-xs-1"></th>
            </tr>
            </thead>
            <tbody>
                <?php
                foreach ($parcours as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row["nom"] ?></td>
                        <!--td><?php echo $row["objectif"] ?></td-->
                        <td><?php echo $row["code"] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span><span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo base_url('Parcours/modif/') . '/' . $row["id_parcours"] ?>">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modifier</a></li>
                                    <li><a href="<?php echo base_url(); ?>Parcours/supprimer/<?php echo $row["id_parcours"] ?>" onclick="return confirm('Voulez-vous supprimer ce parcours ? Cela peut entraîner des répercussions sur la planification.');">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a></li>
                                    <li><a href="<?php echo base_url('Parcours/visualiser/') . '/' . $row["id_parcours"] ?>">
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Visualiser</a></li>
                                </ul>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>
