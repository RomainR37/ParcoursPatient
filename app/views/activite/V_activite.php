
<div class="container-fluid">
    <div class="jumbotron">
        <h3> Activités existantes </h3>
        <a href="<?php echo base_url('Activites/ajout/') ?>">Ajouter une activite</a>
        <table name="formu"class="table table-responsive table-hover">
            <thead>         
                <tr>
                    <th class="col-xs-2">Nom Activite</th>
                    <th class="col-xs-2">Durée (min)</th>
                    <th class="col-xs-2">Personnels</th>
                    <th class="col-xs-2">Salles</th>
                    <th class="col-xs-3">Commentaires</th>
                    <th class="col-xs-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($activite as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row["nom_activite"] ?></td>
                        <td><?php echo $row["duree"] ?></td>
                        <td>
                            <?php foreach ($row["ressourcesH"] as $res) { ?>
                                <?php echo $res["nom_ressource"] ?> : <?php echo $res["quantite"] ?><br/> <?php
                            }
                            ?>
                        </td>

                        <td>
                            <?php foreach ($row["ressourcesMat"] as $res) { ?>
                                <?php echo $res["nom_ressource"] ?> : <?php echo $res["quantite"] ?><br/> <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $row["commentaire"] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span><span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo base_url('Activites/modif/') . '/' . $row["id_activite"] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modifier</a></li>
                                    <li><a href="<?php echo base_url(); ?>Activites/suppr/<?php echo $row["id_activite"] ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
<?php } ?>

            </tbody>
        </table>
    </div>
</div>
