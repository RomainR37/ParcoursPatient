<div class="jumbotron"> 	
    <h3>Disponibilités du patient</h3>
    <br>
    <div class="form-horizontal col-md-12">
        <div class="form-group row ">
            <label for="parcours" class="col-md-2 control-label">Nom du parcours</label>
            <div class="col-md-10">
                <select id="parcours" name="parcours" class="form-control" >
                    <?php foreach ($parcours as $p) { ?>
                        <option value="<?php echo $p["id_parcours"]; ?>"><?php echo $p["nom"]; ?></option>
                    <?php } ?>
                </select>
            </div> 
        </div>
    </div>  
    <div class="row">
        <div id="calendar_basic" class="col-lg-12">
        </div>
    </div>
    <div class="saisieDispo hidden row">
        <h4>Horaire disponible pour le : <span id="dateDispo"></span></h4>  
        <form action="<?php if ($pathForm == "patient/ajoutPatient") { echo base_url();?>patient/majDisponibilite/ <?php } 
            else if($pathForm == "patient/ajouterRDV") { echo base_url();?>patient/ajoutDossier/ <?php }
            else { echo base_url();?>patient/majDossier/<?php echo $id_dossier ?> <?php } ?> " method="POST" accept-charset="utf-8">
            
            <div class="form-horizontal col-md-12">
                <div class="form-group row ">
                    <label for="heureDebut" class="col-md-2 control-label">Heure d'arrivée</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="heureDebut" id="heureDebut"  value="" required>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="heureFin" class="col-md-2 control-label">Heure de départ</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="heureFin" id="heureFin"  value="" required>
                    </div>
                </div>
                <div class="form-group row hidden">
                    <label for="idParcours" class="col-md-2 control-label">Parcours</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="idParcours" id="idParcours"  value="">
                    </div>
                </div>
                <div class="form-group row hidden">
                    <label for="idPatient" class="col-md-2 control-label">idPatient</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="idPatient" id="idPatient"  value="<?php echo $idPatient; ?>">
                    </div>
                </div>
            </div>


            <div class="pull-right col-md-2">
                <button class="btn btn-success" type="submit" ><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Ajouter</button>
            </div>
            <div class="pull-right col-md-2">
                <button class="btn btn-warning" type="reset"><span class="glyphicon glyphicon-cross" aria-hidden="true"></span> Annuler</button>
            </div>

        </form>

    </div>
</div>


<script type="text/javascript">
    var idParcours = 1;
    var dateChoisie;
    $("body").delegate("#heureFin", "focusin", function () {
        $(this).timepicker({
            'timeFormat': 'H:i',
            'step': 5,
            'minTime': '9:00am',
            'maxTime': '8:00pm'
        });
    });

    $("body").delegate("#heureDebut", "focusin", function () {
        $(this).timepicker({
            'timeFormat': 'H:i',
            'step': 5,
            'minTime': '8:00am',
            'maxTime': '7:00pm'
        });
    });

    $("body").on('change', '#parcours', function (event) {
        event.preventDefault();
        idParcours = $(this).val();
        drawChart();
    });

    $("body").delegate("form", "submit", function () {
        $("#heureDebut").val($.datepicker.formatDate('yy-mm-dd', new Date(dateChoisie)) + " " + $("#heureDebut").val() + ":00");
        $("#heureFin").val($.datepicker.formatDate('yy-mm-dd', new Date(dateChoisie)) + " " + $("#heureFin").val() + ":00");
    });


    google.load("visualization", "1.1", {packages: ["calendar"]});
    google.setOnLoadCallback(drawChart);



    function drawChart() {
        $("#idParcours").val(idParcours);
        var dateDebut = $.datepicker.formatDate('yy-mm-dd', new Date());
        $.ajax({
            type: "POST",
            //headers: { 'X-XSRF-TOKEN' : $_token }, 
            data: {"idParcours": idParcours, "dateDebut": dateDebut},
            url: '<?php echo base_url("Patient/getNbByDay"); ?>', //La route
            dataType: "json", //Le type de donnée de retour
            success: function (data) { //La fonction qui est appelée si la requête a fonctionné.
                //console.log(data);
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('date', 'date');
                dataTable.addColumn('number', 'pourcentage d\'occupation');
                console.log(dataTable);
                for (var i = data.length - 1; i >= 0; i--) {
                    var dateTab = new Date(data[i].date);
                    var ratioTab = data[i].ratio * 10;
                    dataTable.addRow(
                            [dateTab, parseInt(ratioTab)]
                            );
                    //window.alert(ratioTab);
                }
                ;

                var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

                var options = {
                    title: "Disponibilités",
                    height: 350,
                    colorAxis: {
                        minValue: 0,
                        maxValue: 50,
                        colors: ['#FFFFFF', '#FF0000']
                    },
                    calendar: {
                        cellColor: {
                            stroke: '#76a7fa',
                            strokeOpacity: 0.5,
                            strokeWidth: 1,
                        },
                        daysOfWeek: 'DLMMJVS'
                    },
                    noDataPattern: {
                        backgroundColor: '#FFFFFF',
                        color: '#FFFFFF'
                    }
                };


                function selectJour()
                {
                    var selectedItem = chart.getSelection()[0];
                    dateChoisie = new Date(selectedItem.date);
                    $("#dateDispo").html($.datepicker.formatDate('dd/mm/yy', new Date(selectedItem.date)));
                    $("#heureFin").val("");
                    $("#heureDebut").val("");
                    $(".saisieDispo").removeClass('hidden');
                }


                google.visualization.events.addListener(chart, 'select', selectJour);
                chart.draw(dataTable, options);
            },
            error: function () { //La fonction qui est appelée si une erreur est survenue.
                $("#post").html('Une erreur est survenue.');
            },
        });


    }
</script>
