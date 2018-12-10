<div class="container-fluid" >  
    
    <div class="jumbotron">	
        <?php
        if ($pathForm == "patient/ajoutPatient") {
            echo "<h3>Ajout d'un nouveau patient</h3>";
        } else {
            echo "<h3>Modification d'un patient</h3>";
        }
        ?>

        <br>
        
        <div class="row">

            <div class="form-horizontal col-md-12">	
                
                <form action="<?php echo base_url($pathForm); ?>" method="POST" accept-charset="utf-8">
                    <?php echo validation_errors(); ?>

                    <?php echo form_open('form'); ?>
                    <div class="form-horizontal col-md-12">
                        <div class="form-group row">
                            <label for="id-patient" class="col-md-2 control-label hidden">ID patient</label>
                            <div class="col-md-10">
                                <?php
                                $idP = array(
                                    'name' => 'id-patient',
                                    'id' => 'id-patient',
                                    'value' => set_value('id-patient'),
                                    'class' => 'form-control hidden',
                                    'type' => 'text'
                                );
                                echo form_input($idP);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="nom-patient" class="col-md-2 control-label">Nom</label>
                            <div class="col-md-10">
                                <?php
                                $nom = array(
                                    'name' => 'nom-patient',
                                    'id' => 'nom-patient',
                                    'value' => set_value('nom-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($nom);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="prenom-patient" class="col-md-2 control-label">Prénom</label>
                            <div class="col-md-10">
                                <?php
                                $prenom = array(
                                    'name' => 'prenom-patient',
                                    'id' => 'prenom-patient',
                                    'value' => set_value('prenom-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($prenom);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="num-add-patient" class="col-md-2 control-label">Numéro de rue</label>
                            <div class="col-md-10">
                                <?php
                                $numAdd = array(
                                    'name' => 'num-add-patient',
                                    'id' => 'num-add-patient',
                                    'value' => set_value('num-add-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($numAdd);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="rue-add-patient" class="col-md-2 control-label">Rue</label>
                            <div class="col-md-10">
                                <?php
                                $rueAdd = array(
                                    'name' => 'rue-add-patient',
                                    'id' => 'rue-add-patient',
                                    'value' => set_value('rue-add-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($rueAdd);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="cp-add-patient" class="col-md-2 control-label">Code postal</label>
                            <div class="col-md-10">
                                <?php
                                $cpAdd = array(
                                    'name' => 'cp-add-patient',
                                    'id' => 'cp-add-patient',
                                    'value' => set_value('cp-add-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($cpAdd);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="ville-add-patient" class="col-md-2 control-label">Ville</label>
                            <div class="col-md-10">
                                <?php
                                $villeAdd = array(
                                    'name' => 'ville-add-patient',
                                    'id' => 'ville-add-patient',
                                    'value' => set_value('ville-add-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($villeAdd);
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pays-add-patient" class="col-md-2 control-label">Pays</label>
                            <div class="col-md-10">
                                <?php
                                $paysAdd = array(
                                    'name' => 'pays-add-patient',
                                    'id' => 'pays-add-patient',
                                    'value' => set_value('pays-add-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($paysAdd);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="email-patient" class="col-md-2 control-label">Email</label>
                            <div class="col-md-10">
                                <?php
                                $email = array(
                                    'name' => 'email-patient',
                                    'id' => 'email-patient',
                                    'value' => set_value('email-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($email);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="num-fixe-patient" class="col-md-2 control-label">Téléphone fixe</label>
                            <div class="col-md-10">
                                <?php
                                $numFixe = array(
                                    'name' => 'num-fixe-patient',
                                    'id' => 'num-fixe-patient',
                                    'value' => set_value('num-fixe-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($numFixe);
                                ?>
                            </div>
                        </div>	
                        <div class="form-group row">
                            <label for="tel-port-patient" class="col-md-2 control-label">Téléphone portable</label>
                            <div class="col-md-10">
                                <?php
                                $numPort = array(
                                    'name' => 'tel-port-patient',
                                    'id' => 'tel-port-patient',
                                    'value' => set_value('tel-port-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($numPort);
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="num-secu-patient" class="col-md-2 control-label">Numéro de sécurité sociale</label>
                            <div class="col-md-10">
                                <?php
                                $numSS = array(
                                    'name' => 'num-secu-patient',
                                    'id' => 'num-secu-patient',
                                    'value' => set_value('num-secu-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($numSS);
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date-naiss-patient" class="col-md-2 control-label">Date de naissance</label>
                            <div class="col-md-10">
                                <?php
                                $dateNaiss = array(
                                    'name' => 'date-naiss-patient',
                                    'id' => 'date-naiss-patient',
                                    'value' => set_value('date-naiss-patient'),
                                    'class' => 'form-control',
                                    'type' => 'text'
                                );
                                echo form_input($dateNaiss);
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="pull-right col-md-2">
                        <button class="btn btn-success" type="submit" ><span class="glyphicon glyphicon-ok" aria-hidden="true"></span><?php
                            if ($pathForm == "patient/ajoutPatient") {
                                echo "Ajouter";
                            } else {
                                echo " Confirmer";
                            }
                            ?>         </button>
                    </div>
                    <div class="pull-right col-md-2">
                        <button class="btn btn-warning" type="reset"><span class="glyphicon glyphicon-cross" aria-hidden="true"></span> Annuler</button>
                    </div>

                </form>
            </div>
        </div>
       
    </div> 
  

</div> <!-- /container -->

<script type="text/javascript">
    $("body").delegate("#date-naiss-patient", "focusin", function () {
        $(this).datepicker();
    });
</script>