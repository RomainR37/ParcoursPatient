<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div class="container-fluid">
    <div class="jumbotron">
        <label for="id-patient" class="col-md-2 control-label hidden">ID patient</label>
        <h3> RDVs de <?php echo $dossierParcours["txt_nom"] . " " . $dossierParcours["txt_prenom"]; ?> </h3>
        <a href="<?= base_url()?>Patient/ajouterRDV/<?php echo $id_patient;?>">Ajouter un nouveau RDV</a>
        <table name="formu"class="table table-responsive table-hover">
            <thead>         
            <th class="col-xs-3">Date de RDV</th>
            <!--th class="col-xs-1">Objectif</th-->
            <th class="col-xs-3">Nom de Parcours</th>
            <th class="col-xs-1"></th>
           
            </thead>
            <tbody>
                
                    <?php
                foreach ($dossierParcours["dossierParcours"] as $dossier) {
                    ?>
                    
                <tr>
                        <td><?php echo $dossier["date_disponible_debut"]; ?></td>
                        
                        <td><?php echo $dossier["nom_parcours"]; ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span><span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    
                                    <li><a href="<?= base_url()?>Patient/modifierRDV/<?php echo $id_patient;?>/<?php echo $dossier["id_dossierparcours"];?>">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modifier</a></li>
                                    <li><a href="<?= base_url()?>Patient/supprimerRDV/<?php echo $id_patient;?>/<?php echo $dossier["id_dossierparcours"];?>" onclick="return confirm('Voulez-vous supprimer ce rendez-vous ? Cela peut entraîner des répercussions sur la planification.');">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a></li>
                                 
                                </ul>
                            </div>
                        </td>
                    </tr>
                    
                    
<?php } ?>
            </tbody>
        </table>
    </div>
</div>

