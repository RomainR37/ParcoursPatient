<div class="container-fluid">
    <div class="jumbotron">
        <h3><?php
            if ($id != -1) {
                echo 'Modifier';
            } else {
                echo 'Ajouter';
            }
            ?> un parcours-patient</h3>

        <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>Parcours/confirmModif" method="POST">

            <div class="row">
                <fieldset class="col-md-12">

                    <legend></legend>
                    <div class="form-group">
                        <label for="nom" class="col-sm-2 control-label" >Nom Parcours-Patient</label>
                        <div class="col-sm-10">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="text" class="form-control" name="nom" placeholder="Entrez le nom du parcours"  value="<?php echo $nom; ?>">
                        </div>
                    </div>

                   

                    <div class="form-group">
                        <label for="commentaire" class="col-sm-2 control-label">Code</label>
                        <div class="col-sm-10">
                            <input type ="text"  class="form-control" name="code" placeholder="Entrez le code du parcours" value="<?php echo $code; ?>">
                        </div>
                    </div> 

                </fieldset>
            </div>

            <div id="confirmActivite" class="hidden">

            </div>

            <div class="row">
                <fieldset class="col-md-12">
                    <legend>Activités</legend>

                    <div class="form-group">
                        <label for="activite" class="col-xs-4 control-label">Nom Activite</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="activite" id="activite" placeholder="Entrez une activité" value="">
                            <input type="hidden" id="idActivite" value="-1">
                        </div>

                        <div class="col-xs-2">
                            <button class="btn btn-primary" id="submitAddActivite"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                        </div>
                        <p style="margin-top: 15px" class="col-xs-12">Si une activité A précède une activité B, il suffit de glisser le nom de l'activité A dans la case correspondant à l'activité B. Les activités correspondant au début du parcours ne possèdent pas d'activité précédente.</p>
                    </div>
                </fieldset>
                <!-- Trigger the modal with a button -->
                <button style="margin-left: 20px"type="button" class="btn btn-info" data-toggle="modal" data-target="#parcours">Visualiser Parcours</button>

                <!-- Modal -->
                <div id="parcours" class="modal fade" role="dialog" onabort="afficherParcours()">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Visualisation du parcours</h4>
                            </div>
                            <div class="modal-body">
                                <input type="button" value="Afficher Parcours" onclick="afficherParcours()">
                                <br>
                                <br>
                                <div id="myDiagramDiv" style="width:864px; height:600px; background-color: #DAE4E4;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <table hidden id="tableActivite">
                    <tbody>
                        <?php foreach ($activites as $a) { ?>
                            <tr><td><input name="activite[]" class="idActivite" value="<?php echo $a["id_activite"] ?>"></td></tr>
                        <?php } ?>
                    </tbody></table>
                <div class = "col-md-12" id="divActivite">
                    <?php foreach ($activites as $a) { ?>
                        <div class="col-md-3 blocActivite">
                            <span hidden class="idActivite"><?php echo $a["id_activite"] ?></span>
                            <span class='activite btn-default'><?php echo $a["nom_activite"] ?><span class=" alert-danger glyphicon glyphicon-remove submitDelActivite" aria-hidden="true"></span></span>
                            <br>Activités précédentes<br>
                            <table hidden class="table_prec prec"><tbody>
                                    <?php foreach ($a["prec"] as $prec) { ?>
                                        <tr><td class='idPrec'><?php echo $prec["id_prec"] ?></td></tr>
                                    <?php } ?></tbody>
                            </table>
                            <ul class="liste_prec prec">
                                <?php foreach ($a["prec"] as $prec) { ?>
                                    <li><span hidden class='idPrec'><?php echo $prec["id_prec"] ?></span><?php echo $prec["nom_prec"] ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <div>
                    </div>
                </div>
                <br>
                <div class ="col-xs-12">
                    <fieldset>
                        <legend>Précédences</legend>
                        <table id="tablePrecedences" class="table table-responsive table-hover">
                            <thead>  <tr><th hidden></th><th hidden></th><th class="col-sm-3">Activité</th><th class="col-sm-3">Activité Précédente</th><th class="col-sm-2">Delai min</th><th class="col-sm-2">Delai max</th><th class="col-sm-2"></th></tr> </thead>
                            <tbody>
                                <?php $i = 0; ?> <?php foreach ($precedences as $row) { ?>
                                    <tr>
                                        <td hidden><input class='idActivite' name='idActivite[]' value="<?php echo $row['id_act'] ?>"></td>
                                        <td hidden><input class='idPrec' name='idPrec[]' value="<?php echo $row['id_prec'] ?>"></td>
                                        <td  class='col-sm-3'><?php echo $row['nom_act'] ?></td>
                                        <td  class='col-sm-3'><?php echo $row['nom_prec'] ?></td>
                                        <td  class='col-sm-2'><input type='number' min=0 class='form-control' name='delaiMin[]'  value="<?php echo $row["delai_min"] ?>"></td>
                                        <td  class='col-sm-2'><input type='number' min=0 class='form-control' name='delaiMax[]'  value="<?php echo $row["delai_max"] ?>"></td>
                                        <td class='col-sm-1'><button class='btn btn-danger submitDelPrec'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>     
            <div class="row">
                <div class=" col-md-6 "></div>
                <div class="pull-right col-md-4">

                    <button type="submit" class="btn btn-success" ><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Confirmer </button>
                    <a href="<?php echo base_url(); ?>Parcours/" class="btn btn-danger" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Annuler </a>

                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    function afficherParcours() {
        var a = go.GraphObject.make;  // for more concise visual tree definitions
        var blue = "#0288D1";
        myDiagram =
                a(go.Diagram, "myDiagramDiv",
                        {
                            initialAutoScale: go.Diagram.Uniform,
                            initialContentAlignment: go.Spot.Center,
                            layout: a(go.LayeredDigraphLayout)
                        });

        myDiagram.nodeTemplate =
                a(go.Node, "Auto",
                        a(go.Shape, "Rectangle", // the border
                                {fill: "white", strokeWidth: 3},
                                new go.Binding("fill", "critical", function (b) {
                                    return (b ? pinkfill : bluefill);
                                }),
                                new go.Binding("stroke", "critical", function (b) {
                                    return (b ? pink : blue);
                                })),
                        a(go.Panel, "Table",
                                {padding: 0.5},
                                a(go.RowColumnDefinition, {column: 1, separatorStroke: "black"}),
                                a(go.RowColumnDefinition, {column: 2, separatorStroke: "black"}),
                                a(go.RowColumnDefinition, {row: 1, separatorStroke: "black", background: "white", coversSeparators: true}),
                                a(go.RowColumnDefinition, {row: 2, separatorStroke: "black"}),
                                a(go.TextBlock,
                                        new go.Binding("text", "text"),
                                        {row: 1, column: 0, columnSpan: 3, margin: 5,
                                            textAlign: "center", font: "bold 14px sans-serif"})
                                )  // end Table Panel
                        );  // end Node

        function linkColorConverter(linkdata, elt) {
            var link = elt.part;
            if (!link)
                return blue;
            var f = link.fromNode;
            if (!f || !f.data || !f.data.critical)
                return blue;
            var t = link.toNode;
            if (!t || !t.data || !t.data.critical)
                return blue;
            return pink;  // when both Link.fromNode.data.critical and Link.toNode.data.critical
        }

        myDiagram.linkTemplate =
                a(go.Link,
                        {toShortLength: 6, toEndSegmentLength: 20},
                        a(go.Shape,
                                {strokeWidth: 4},
                                new go.Binding("stroke", "", linkColorConverter)),
                        a(go.Shape, // arrowhead
                                {toArrow: "Triangle", stroke: null, scale: 1.5},
                                new go.Binding("fill", "", linkColorConverter))
                        );

        //activites
        var nodeDataArray = <?php echo $listeActivites; ?>;

        //listeActivites
        var linkDataArray = <?php echo $listePrecedences; ?>;

        myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);
    }

    $(updateDragDrop());

// autocomplete
    $('#activite').autocomplete({
        source: '<?php echo base_url("Parcours/getAllActivites"); ?>',
        select: function (event, ui) {
            $('#idActivite').attr('value', ui.item.id);
        }
    });

// Ajout d'une activite au tableau
    $('body').on('click', "#submitAddActivite", function (event) {
        event.preventDefault();
        if (!existsInActivite($("#idActivite")[0].value))
        {
            $.ajax({
                type: "POST",
                //headers: { 'X-XSRF-TOKEN' : $_token }, 
                data: {"idActivite": $("#idActivite")[0].value, "nomActivite": $("#activite")[0].value},
                url: "<?php echo base_url('Activites/ajoutActiviteParcours'); ?>", //La route
                dataType: "json", //Le type de donnée de retour
                success: function (data) { //La fonction qui est appelée si la requête a fonctionné.
                    $("#confirmActivite").addClass("visibledivVerif").removeClass('hidden');
                    $("#confirmActivite").html(data);
                },
                error: function () { //La fonction qui est appelée si une erreur est survenue.
                    console.log("error");
                    $("#post").html('Une erreur est survenue.');
                }
            });

        }
    });

// On annule l'ajout d'une activite
    $('body').on('click', "#resetAddActivite", function (event) {
        event.preventDefault();
        $("#confirmActivite").removeClass("visibledivVerif").addClass('hidden');
        $("#confirmActivite").html("");
    });

    $('body').on('click', "#validAddActivite", function (event) {
        event.preventDefault();
        id = $("#id")[0].value;

        // on effectue le traitement des données uniquement en cas de nouvelle activites
        nom = $("#nom")[0].value;
        duree = $("#duree")[0].value;
        commentaire = $("#commentaire")[0].value;
        idType = [];
        qte = [];

// on ajoute les ressources de type personnel
        $("#tablePerso > tbody").children().each(function ()
        {
            idType.push($(this).find('.idType')[0].value);
            qte.push($(this).find('.qte')[0].value);
        });
// on ajoute les ressources de type matériel
        $("#tableRes > tbody").children().each(function ()
        {
            idType.push($(this).find('.idType')[0].value);
            qte.push($(this).find('.qte')[0].value);
        });

        $.ajax({
            type: "POST",
            //headers: { 'X-XSRF-TOKEN' : $_token }, 
            data: {"id": id, "nom": nom, "duree": duree, "commentaire": commentaire, "idType": idType, "qte": qte},
            url: "<?php echo base_url('Activites/confirmModifParcours'); ?>", //La route
            dataType: "json", //Le type de donnée de retour
            success: function (data) { //La fonction qui est appelée si la requête a fonctionné.
                $("#confirmActivite").removeClass("visibledivVerif").addClass('hidden');
                $("#confirmActivite").html("");
                // on ajoute la ligne correspondante
                $('#tableActivite tbody').append("<tr><td><input name='activite[]' class='idActivite' value='" + data["id"] + "'></td></tr>");
                $('#divActivite').append("<div class='col-md-3 blocActivite'>" +
                        "<span hidden class='idActivite'>" + data["id"] + "</span>" +
                        "<span class='activite btn-default'>" + data["nom"] +
                        "<span class='glyphicon glyphicon-remove submitDelActivite alert-danger' aria-hidden='true' ></span></span><br>Activités précédentes<br>" +
                        "<table hidden class='table_prec prec'><tbody></tbody></table><ul class='liste_prec prec'></ul></div>");
                $("#idActivite")[0].value = -1;
                $("#activite")[0].value = "";

                updateDragDrop();
            },
            error: function () { //La fonction qui est appelée si une erreur est survenue.
                console.log("error");
                $("#post").html('Une erreur est survenue.');
            },
        });
    });


// suppression de l'activite
    $('body').on('click', ".submitDelActivite", function (event) {
        event.preventDefault();
        var id = $(this).parent().parent().children(".idActivite").text();
        // on supprime l'activite du tableau
        $("#tableActivite > tbody > tr").each(function ()
        {
            val = $(this).find('.idActivite')[0].value;
            if (id == val)
                $(this).remove();
        });
        // on supprime toutes les precedences où il apparait
        deletePrec(-1, id);
        $(this).parent().parent().remove();
    });

// on vérifie si l'activite n'est pas déjà dans le tableau
    function existsInActivite(id)
    {
        res = false;
        $("#tableActivite > tbody > tr > td ").each(function ()
        {
            val = $(this).find('.idActivite')[0].value;
            if (id == val)
                res = true;
        });
        return res;
    }

// on met à jour les objets draggables
    function updateDragDrop()
    {
        $('.blocActivite .activite').draggable({

            revert: true,
            helper: "clone",
            cursor: "move",
            containment: "#divActivite",
            scroll: false,
            stack: '.blocActivite .activite'});
        $(" .blocActivite").droppable({
            accept: ".activite",
            over: function (e, ui)
            {
                //au survol, on affiche un plus
                if ($(this).find(".idActivite").text() != ui.draggable.parent().find(".idActivite").text())
                {
                    $("#divActivite").children().each(function () {
                        $(this).removeClass("ui-state-hover");
                    });
                    $(this).addClass("ui-state-hover");
                }
            },
            out: function (e, ui)
            {
                $("#divActivite").children().each(function () {
                    $(this).removeClass("ui-state-hover");
                });
            },
            drop: function (event, ui) {
                var new_idActivite = $(this).find(".idActivite").text();
                var nom_activite = $(this).find(".activite").text();
                // on ne peut pas glisser une activité dans elle-même
                if (new_idActivite != ui.draggable.parent().find(".idActivite").text())
                {
                    $("#divActivite").children().each(function () {
                        $(this).removeClass("ui-state-hover");
                    });
                    // on récupère les valeurs draggées
                    var new_idPrec = ui.draggable.parent().find(".idActivite").text();
                    // On vérifie que cette activite n'est pas deja presente dans les precedences
                    if (!existsInPrec(new_idActivite, new_idPrec) && !existsInPrec(new_idPrec, new_idActivite))
                    {
                        nom_prec = ui.draggable.text();
                        // Ajout d'une nouvelle ligne pour l'activite precedente dans la div
                        $(this).find(".liste_prec").append("<li><span hidden class='idPrec'>" + new_idPrec + "</span>" + nom_prec + "</li>");
                        $(this).find(".table_prec").append("<tr><td class='idPrec'>" + new_idPrec + "</td></tr>");
                        // Ajout d'une nouvelle ligne dans le tableau de précédence
                        $("#tablePrecedences").find("tbody").append("<tr>" +
                                "<td hidden><input class='idActivite' name='idActivite[]' value=" + new_idActivite + "></td>" +
                                "<td hidden><input class='idPrec' name='idPrec[]' value=" + new_idPrec + "></td>" +
                                "<td  class='col-sm-3'>" + nom_activite + "</td>" +
                                "<td  class='col-sm-3'>" + nom_prec + "</td>" +
                                "<td  class='col-sm-2'><input type='number' min=0 class='form-control' name='delaiMin[]'  ></td>" +
                                "<td  class='col-sm-2'><input type='number' min=0 class='form-control' name='delaiMax[]'  ></td>" +
                                "<td class='col-sm-1'><button class='btn btn-danger submitDelPrec'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></td>" +
                                "</tr>");
                    }
                }
            }
        });
    }


// on vérifie si l'activite precedente n'est pas déjà dans le tableau
    function existsInPrec(idActivite, idPrec)
    {
        res = false;
        rec = [];
        $("#divActivite").children(".blocActivite").each(function ()
        {
            // On cherche le bloc coreespondant à notre activité
            if (!res && $(this).find('.idActivite').text() == idActivite)
            {
                //On cherche l'item dans la table correspondant à notre précédent
                $(this).find(".table_prec tbody").children().each(function ()
                {
                    id_prec = $(this).text();
                    if (id_prec == idPrec)
                        res = true;
                });
                if (!res)
                {
                    $(this).find(".table_prec tbody").children().each(function ()
                    {
                        id_prec = $(this).text();
                        if (id_prec != idPrec && existsInPrec(id_prec, idPrec))
                            res = true;
                    });
                }
            }
        });
        res_rec = false;
        for (i = 0; i < rec.length; ++i)
            if (rec[i])
                res_rec = true
        return res || res_rec;
    }

    function deletePrec(idActivite, idPrec)
    {
        deletePrecFromDiv(idActivite, idPrec);
        deletePrecFromTable(idActivite, idPrec);
    }

// On supprime la div correspondant à la précédence
    function deletePrecFromDiv(idActivite, idPrec)
    {
        // on supprime la précédence dans la div
        $("#divActivite").children(".blocActivite").each(function ()
        {
            // On cherche le bloc coreespondant à notre activité
            if (idActivite == -1 || $(this).find('.idActivite').text() == idActivite)
            {
                //On cherche l'item dans la liste correspondant à notre précédent (dans la liste ET la table)
                $(this).find('.prec').children().each(function ()
                {
                    if ($(this).find('.idPrec').text() == idPrec)
                        $(this).remove();
                });

                $(this).find('.prec >tbody').children().each(function ()
                {
                    if ($(this).find('.idPrec').text() == idPrec)
                        $(this).remove();
                });
            }
        });
    }

    function deletePrecFromTable(idActivite, idPrec)
    {
        deleted = false;
        $("#tablePrecedences tbody").children().each(function ()
        {
            if ((idActivite == -1 // Si aucune activite est renseignee, on supprime toutes les precedences où idPrec apparait
                    && ($(this).find('.idPrec')[0].value == idPrec
                            || $(this).find('.idActivite')[0].value == idPrec))
                    || (!deleted // sinon on verifie les 2 id pour supprimer la ligne
                            && $(this).find('.idActivite')[0].value == idActivite
                            && $(this).find('.idPrec')[0].value == idPrec))
            {
                $(this).remove();
                deleted = true;
            }
        });
    }

// suppression d'une precedence
    $('body').on('click', ".submitDelPrec", function (event) {
        event.preventDefault();
        var idAct = $(this).parent().parent().find(".idActivite")[0].value;
        var idPrec = $(this).parent().parent().find(".idPrec")[0].value;
        // on supprime l'activite du tableau
        deletePrec(idAct, idPrec);
    });
</script>