<div class="container-fluid" >  
    <div class="jumbotron">	
        <h3>Créer jeu de données</h3>
        <br>
        <div class="row">
            <div class='col-md-6'>
                <div class="form-group">
                    <label>Choisir une date : </label>
                    <div class='input-group date'>
                        <input type='date' id='date' class="form-control" required="true"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">           
                <a onclick="creerDonnees()"><button type="button" class="btn btn-success">Créer jeu de données</button></a>
            </div>
        </div>
    </div>
</div>
<script>
    function creerDonnees() {
        var date = document.getElementById("date").value;


        $.ajax({
            type: "POST",
            data: {"date": date},
            url: '<?php echo base_url("Planning/deleteEvent"); ?>', //La route
            dataType: "json", //Le type de donnée de retour
            success: function (response) {

            }
        });
    }
</script>