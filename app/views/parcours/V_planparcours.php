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
                    <table id="tab_planparcours" class="table table-responsive table-hover">
                        <thead>         
                            <tr>
                                <th onclick="sortTable(0)" class="col-xs-1">Parcours</th>
                                <th onclick="sortTable(1)" class="col-xs-1">Jour</th>
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
                    $("#tab_planparcours").replaceWith(data);

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
                            },
                            error: function (data) {
                                    console.log("erreur", data);
                            },
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

<script>
    function sortTable(n) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("tab_planparcours");
      switching = true;
      // Set the sorting direction to ascending:
      dir = "asc";
      /* Make a loop that will continue until
      no switching has been done: */
      while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
          // Start by saying there should be no switching:
          shouldSwitch = false;
          /* Get the two elements you want to compare,
          one from current row and one from the next: */
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          /* Check if the two rows should switch place,
          based on the direction, asc or desc: */
          if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /* If a switch has been marked, make the switch
          and mark that a switch has been done: */
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          // Each time a switch is done, increase this count by 1:
          switchcount ++;
        } else {
          /* If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again. */
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }
</script>