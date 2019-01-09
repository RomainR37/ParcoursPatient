<div class="container-fluid">
    <div class="jumbotron">
        <h3>Ressources de l'hôpital</h3>
        <a href="<?php echo base_url(); ?>RessourcesMat/ajout/">Ajouter une ressource</a>
        <table id="tab_ress" name="formu" class="table table-responsive table-hover">
            <thead>         
                <tr>
                    <th onclick="sortTable(0)" class="col-xs-5">Nom de la ressource</th>
                    <th onclick="sortTable(1)" class="col-xs-5">Spécialité</th>
                    <th class="col-xs-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($ressources as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row["txt_nom"] ?></td>
                        <td><?php echo $row["type"] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span><span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo base_url(); ?>RessourcesMat/modif/<?php echo $row["id_salle"] ?>">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modifier</a></li>
                                    <li><a href="<?php echo base_url(); ?>RessourcesMat/suppr/<?php echo $row["id_salle"] ?>" onclick="return confirm('Voulez-vous supprimer cette ressource ? Cela peut entraîner des répercussions sur la planification.');">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer</a></li>
                                </ul>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<script>
    function sortTable(n) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("tab_ress");
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