<div class="container-fluid">    
    <div class="jumbotron">
        <h3> Tout le personnel de l'hopital </h3>
        <a href="<?php echo base_url(); ?>Personnels/ajout/">Ajouter une personnne</a>
        <table name="formu"class="table table-responsive table-hover">
            <thead>         
                <tr>
                    <th class="col-xs-3">NOM</th>
                    <th class="col-xs-3">Prenom</th>
                    <th class="col-xs-4">Fonctionnalite</th>
                    <th class="col-xs-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($personnels as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row["txt_nom"] ?></td>
                        <td><?php echo $row["txt_prenom"] ?></td>
                        <td><?php echo $row["type"] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span><span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo base_url(); ?>Personnels/modif/<?php echo $row["id_personnel"] ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modifier</a></li>
                                    <li><a href="<?php echo base_url(); ?>Personnels/suppr/<?php echo $row["id_personnel"] ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a></li>
                                    <li><a href="<?php echo base_url(); ?>EtreIndispo/afficher/<?php echo $row["id_personnel"] ?>"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Indisponibilité</a></li>
                                </ul>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>
