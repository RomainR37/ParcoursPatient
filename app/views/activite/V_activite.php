<div class="container-fluid">
    <div class="jumbotron">
        <h3>Activités existantes</h3>
        <a href="<?php echo base_url('Activites/ajout/') ?>">Ajouter une activité</a>
        <table id="tab_act" name="formu" class="table table-responsive table-hover">
            <thead>
                <tr>
                    <th onclick="sortTable(0)" class="col-xs-2">Nom Activité</th>
                    <th onclick="" class="col-xs-2">Durée (en minutes)</th>
                    <th onclick="" class="col-xs-2">Personnels</th>
                    <th onclick="" class="col-xs-2">Salles</th>
                    <th onclick="" class="col-xs-3">Commentaires</th>
                    <th onclick="" class="col-xs-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($activite as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row["nom_activite"] ?></td>
                        <td><?php echo $row["duree"] ?></td>
                        <td>
                            <?php foreach ($row["ressourcesH"] as $res) { ?>
                                <?php echo $res["nom_ressource"] ?> : <?php echo $res["quantite"] ?><br/> <?php
                            }
                            ?>
                        </td>

                        <td>
                            <?php foreach ($row["ressourcesMat"] as $res) { ?>
                                <?php echo $res["nom_ressource"] ?> : <?php echo $res["quantite"] ?><br/> <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $row["commentaire"] ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span><span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="<?php echo base_url('Activites/modif/') . '/' . $row["id_activite"] ?>">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Modifier</a></li>
                                    <li><a href="<?php echo base_url(); ?>Activites/suppr/<?php echo $row["id_activite"] ?>" onclick="return confirm('Voulez-vous supprimer cette activité ? Cela peut entraîner des répercussions sur les parcours-patients.');">
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

<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("tab_act");
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