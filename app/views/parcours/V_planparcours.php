<div class="container-fluid">
    <div class="jumbotron">
        <h3> Attribution du nombre de patients par parcours</h3>
        <div class="container" style="padding-top:5%">
            <!--formulaire pour choisir un parcours à afficher-->
            <div class="col-md-3">
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Liste de parcours</label>
                        <select id="selectedid" class="form-control" onchange="showparcours(this.value)">
                            <option value="0" default=""> Tous </option>
                            <?php
                            foreach ($nomparcours as $row) {
                                ?>
                                <option value=<?php echo $row["id_parcours"] ?>><?php echo $row["nom_parcours"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
            </div>

            <!--tableau qui affiche les infos & permet de faire des modifications-->
            <div class="col-md-9" id="data">
                <div class="span10 rightdiv">
                    <table id="mytable" class="table table-responsive table-hover">
                        <thead>         
                            <tr>
                                <th class="col-xs-1">Parcours</th>
                                <th class="col-xs-1">Jour</th>
                                <th class="col-xs-1">Nb de patients</th>
                            </tr>
                        </thead>

                        <form id="newform" method="POST" >
                            <tbody id="dataform">
                                <?php
                                foreach ($planparcours as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row["nom_parcours"] ?></td>
                                        <td><?php echo $row["jour"] ?></td>
                                <input name="id_parcours[]" type="hidden" value="<?php echo $row["id_parcours"] ?>"/>
                                <input name="info_jour[]" type="hidden" value="<?php echo $row["jour"] ?>"/>
                                <td><input name="info_nb[]" type="number" value="<?php echo $row["nb_patient"] ?>" style="width:45px" onchange="$(this).attr('value', validate($(this).val(), 0, 99).toString());$(this).val(validate($(this).val(), 0, 99))" min=0 max=99 /></td>
                                </tr>
                            <?php } ?>  
                            </tbody>

                            <div class="pull-right col-md-2">
                                <button id="btnSubmit" type="submit" class="btn btn-success">Sauvegarder</button>
                            </div>
                        </form>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        $(".close").click(function () {
            $("#myAlert").alert();
        });
    });
</script> 

<script type="text/javascript">
//afficher que le parcours choisi
    function showparcours(i)
    {
        $.post("<?php echo base_url(); ?>PlanParcours/afficheParcours",
                {
                    id: i
                },
                function (data, status) {

                    $("#dataform").replaceWith("");
                    $("#mytable").replaceWith(data);

                });
    }
</script>

<script type="text/javascript">
//sauvegarder les modifications
    $(document).ready(function () {
        $("#btnSubmit").click(function () {
            var dataformu;
            var backup = $("#newform").html();
            if ($("#newform").serialize() != "") {
                dataformu = $("#newform").serialize();
            } else {
                dataformu = $("#newform").html($('#dataform').html()).serialize();
            }
                	var options = {
                        	url: '<?php echo base_url(); ?>PlanParcours/savechanges',
                            type: 'post',
                            dataType: 'text',
                            data: dataformu,
                traditional: true,
                            success: function (data) {
                                	if (data.length > 0)
                                        	alert("Modifications avec succès.");
                            }
                    };
            //$("#newform").ajaxSubmit(options);
                    $.ajax(options);
            $("#newform").html(backup);

                    return false;
        });
    });
    function validate(value, min, max) {
        if (value < min) {
            return min;
        } else if (value > max) {
            return max;
        }
        return value;
    }
</script>
