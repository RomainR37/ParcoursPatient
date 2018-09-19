<div class="container-fluid">
    <div class="jumbotron">
        <h3><?php if ($id != -1) {
    echo 'Modifier';
} else {
    echo 'Ajouter';
} ?> une personne</h3>

        <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>Personnels/confirmModif" method="POST">

            <div class="row">
                <fieldset class="col-md-6">

                    <legend></legend>
                    <div class="form-group">
                        <label for="nom" class="col-sm-4 control-label" >Nom</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="idRessource" value="<?php echo $idRessource ?>">
                            <input type="text" class="form-control" name="nom" placeholder="Entrez votre nom" required value="<?php echo $nom; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prenom" class="col-sm-4 control-label">Prenom</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="prenom" placeholder="Entrez votre prenom" required value="<?php echo $prenom; ?>">
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="type" class="col-sm-4 control-label">Type personnel</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="type" id="type" placeholder="Entrez un type" required value="<?php echo $type; ?>">
                            <input type="hidden" name="idType" id="idType" value="<?php echo $idType ?>">
                        </div>
                    </div>

                </fieldset>

<?php if ($id == -1) { ?><fieldset class="col-md-6">
                        <legend></legend>
                        <div class="form-group">
                            <label for="nom" class="col-sm-4 control-label" >Identifiant</label>
                            <div class="col-sm-8">  
                                <input type="text" class="form-control" name="login" placeholder="Entrez une identifiant" required>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="nom" class="col-sm-4 control-label" >Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" placeholder="Entrez votre password" required>
                            </div>
                        </div>

                    </fieldset><?php } ?>

            </div>

            <div class="row">
                <div class=" col-md-6 "></div>
                <div class="pull-right col-md-4">

                    <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirmer </button>
                    <a href="<?php echo base_url("Personnels"); ?>" class="btn btn-danger " ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Annuler </a>

                </div>
            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
    $('#type').autocomplete({
        source: '<?php echo base_url("Personnels/getTypes"); ?>',
        select: function (event, ui) {
            $('#idType').attr('value', ui.item.id);
        }
    });
</script>
