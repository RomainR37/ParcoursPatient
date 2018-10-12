<div class="container-fluid" >  
    <div class="jumbotron">	
        <h3>Recherche d'un patient</h3>
        <br>
        <div class="row">		
            <div class="form-group">
                <div class="input-group input-group-lg icon-addon addon-lg">
                    <input type="text" placeholder="Entrez un nom de patient" name="recherche" id="recherche" class="form-control input-lg">
                    <i class="icon icon-search"></i>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-inverse">Rechercher</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="jumbotron">	
        <h3>Résultat de la recherche : </h3>
        <div class="tableRecherche">

        </div>
    </div>
</div> <!-- /container -->



<script type="text/javascript">
    $('body').on('keyup', '#recherche', function (event) {
        var rech = $("#recherche").val();
        $.ajax({
            type: "POST",
            data: {"recherche": rech},
            url: "<?php echo base_url(); ?>Patient/faireRecherche", //La route
            dataType: "json", //Le type de donnée de retour
            success: function (data) { //La fonction qui est appelée si la requête a fonctionné.
                //console.log(data);
                $(".tableRecherche").html(data);
            },
            error: function () { //La fonction qui est appelée si une erreur est survenue.
                $("#post").html('Une erreur est survenue.');
            },
        });
    });
</script>