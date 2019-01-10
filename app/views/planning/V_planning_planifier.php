<div class="container-fluid" >  
    <div class="jumbotron">	
        <h3>Planification</h3>
        <br>

        <div class="row">
            <a href="<?php echo base_url("Planning/sauvegarder"); ?>"><button type="button" class="btn btn-success">Sauvegarder</button></a>
            <a href="<?php echo base_url("Planning/restaurer"); ?>"><button style="margin-left: 25px" type="submit" class="btn btn-primary">Restaurer</button></a>
            <button style="margin-left: 25px" type="submit" class="btn btn-danger" onclick="planificationAuto()">Planifier automatiquement</button>
        </div>
        <div class="row">
            <div style=" margin-top: 20px;width:500px;height:250px;overflow:scroll;overflow-x:hidden;" id='external-events' class="col-md-4">
                <center><h4>Activités</h4></center>
                <div class="form-group">
                    <input type="text" placeholder="Entrer un nom de patient" id="rechercher" class="form-control left-rounded" oninput="rechercher()">
                </div>
                <div id="activites">

                </div>
            </div>
            <div style=" margin-left: 25px;margin-top: 20px; width: 250px" id='external-events' class="col-md-2">
                <div id="trash">
                    <center><h4>Suppression</h4></center>
                    <p>
                    <center><img class='img-responsive' alt='Corbeille' src="<?php echo base_url(); ?>assets/images/trashcan.png"/></center>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- détails d'une activité --> 
            <div id="eventContent" title="Event Details" style="display:none;">
                Debut: <span id="startTime"></span><br>
                Fin: <span id="endTime"></span><br><br>
                <span style="display: none" id="id"></span><br>
                <span style="display: none" id="idParcours"></span>
                <span style="display: none" id="idActivite"></span>
                <p id="eventInfo"></p>
                <button type="submit" onclick="supprimerActivitesPatient()"class="btn btn-danger">Supprimer toutes les activités de ce patient</button>
                <button type="submit" onclick="supprimerActivites()"class="btn btn-success">Supprimer cette activité</button>
            </div>
        </div>
        <div class="row">
            <!-- détails d'une activité externe--> 
            <div id="eventDescription" title="Event Details" style="display:none;">
                <br>
                <br>
                <p id="eventDescriptionTitle"></p>
                <br>
                <br>
                <p id="eventDescriptionInfo"></p>
                <br>
                <br>
                <p id="eventDescriptionPrecedence"></p>
            </div>
        </div>
        <div style="margin-top:25px" class="row">
            <div id="calendar-holder"></div>
        </div>        <div class="row"style="margin-top: 20px">
            <div class="panel panel-info" style="width: 800px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Infos sur la planification</h3>
                </div>
                <div class="panel-body" style="height:300px;overflow:scroll;overflow-x:hidden;">
                    <div id="constraints">
                        <ul id="ul_constraints">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> <!-- /container -->

<script>

    $(function () {

        /* Suppression */
        var currentMousePos = {
            x: -1,
            y: -1
        };
        jQuery(document).on("mousemove", function (event) {
            currentMousePos.x = event.pageX;
            currentMousePos.y = event.pageY;
        });
        function isElemOverDiv() {
            var trashEl = jQuery('#trash');
            var ofs = trashEl.offset();
            var x1 = ofs.left;
            var x2 = ofs.left + trashEl.outerWidth(true);
            var y1 = ofs.top;
            var y2 = ofs.top + trashEl.outerHeight(true);
            if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
                    currentMousePos.y >= y1 && currentMousePos.y <= y2) {
                return true;
            }
            return false;
        }

        $('#selector button').click(function () {
            $(this).addClass('active').siblings().removeClass('active');
            // TODO: insert whatever you want to do with $(this) here
        });
        /* initialize the external events
         -----------------------------------------------------------------*/
        $('#external-events .fc-event').each(function () {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()),
                activiteId: parseInt($(this).attr('activiteID')),
                patientId: parseInt($(this).attr('patientID')),
                parcoursId: parseInt($(this).attr('parcoursID')),
                duration: $.trim($(this).attr('duree')),
                activite_precedente: $.trim($(this).attr('activite_precedente')),
                necessite: $.trim($(this).attr('necessite'))
            });
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0, //  original position after the drag
                scroll: false
            });
        });
        /* initialize the calendar
         -----------------------------------------------------------------*/
        $('#calendar-holder').fullCalendar({
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            timezone: 'France/Paris',
            height: "auto",
            contentHeight: "auto",
            //aspectRatio: 2,
            editable: true, // don't allow event dragging
            eventResourceEditable: true, // except for between resources
            scrollTime: '00:00',
            minTime: "08:00:00",
            maxTime: "20:00:00",
            eventDurationEditable: false,
            eventOverlap: true,
            header: {
                left: 'today prev,next',
                center: 'title',
                right: 'timelineDay,timelineHour,timetwoHours'
            },
            defaultView: 'timelineHour',
            slotDuration: '00:05:00',
            eventConstraint: {
                start: '08:00',
                end: '20:00'
            },
            views: {

                timelineDay: {
                    buttonText: ':5 minutes',
                    slotDuration: '00:05:00'
                },
                timelineHour:
                        {type: 'timeline',
                            buttonText: ':1 heure',
                            slotDuration: '01:00'
                        },
                timetwoHours:
                        {
                            type: 'timeline',
                            buttonText: ':2 heures',
                            slotDuration: '02:00'
                        }
            },
            resourceAreaWidth: '25%',
            resourceLabelText: 'Ressources',
            resourceGroupField: 'type_ressource',
            //filterResourcesWithEvents: true,
            droppable: true, // this allows things to be dropped onto the calendar
            resources: {
                type: "GET",
                url: '<?php echo base_url("Planning/getRessources"); ?>'
            },
            viewRender: function (event) {
                rechercher();
                constraints();
            },
            events: {
                type: "GET",
                url: '<?php echo base_url("Planning/getEvenement"); ?>'
            },
            /* Affichage d'une description des activités */
            eventRender: function (event, element) {
                element.attr('href', 'javascript:void(0);');
                element.click(function ()
                {
                    $("#startTime").html(moment(event.start).format('LLLL'));
                    $("#endTime").html(moment(event.end).format('LLLL'));
                    $("#eventInfo").html("Activités précédentes : " + event.activite_precedente);
                    $("#eventContent").dialog({modal: true, title: event.title, width: 600, height: 200});
                    $("#id").html(event.patientId);
                    $("#idParcours").html(event.parcoursId);
                    $("#idActivite").html(event.activiteId);
                });
            },
            eventReceive: function (event) {
                var title = event.title;
                var start = event.start.toString();
                var end = event.end.toString();
                var ressourceId = event.resourceId;
                var activiteId = event.activiteId;
                var patientId = event.patientId;
                var parcoursId = event.parcoursId;
                $.ajax({
                    type: "POST",
                    data: {"title": title, "start": start, "end": end, "ressourceId": ressourceId, "activiteId": activiteId, "patientId": patientId, "parcoursId": parcoursId},
                    url: '<?php echo base_url("Planning/addEvent"); ?>', //La route
                    dataType: "json", //Le type de donnée de retour
                    success: function (response) {
                        //console.log('Event added with succes', response);
                        $('#calendar-holder').fullCalendar('refetchEvents');
                        //console.log(event);
                        constraints();
                        rechercher();
                    },
                    error: function (e) {
                        console.log('error', e.responseText);
                    }
                });
            },
            eventDragStop: function (event) {
                if (isElemOverDiv()) {
                    if (event.id !== "-1") {
                        $.ajax({
                            type: "POST",
                            data: {"idActivite": event.activiteId, "idPatient": event.patientId, "idParcours": event.parcoursId},
                            url: '<?php echo base_url("Planning/deleteEvent"); ?>', //La route
                            dataType: "json", //Le type de donnée de retour
                            success: function (response) {
                                //console.log("Element supprimé");
                                $('#calendar-holder').fullCalendar('refetchEvents');
                                constraints();
                                rechercher();
                            }
                        });
                    }
                }
            },
            eventDrop: function (event) {
                //console.log(id);
                var start = event.start.toString();
                var end = event.end.toString();
                var ressourceId = event.resourceId;
                $.ajax({
                    type: "POST",
                    data: {"start": start, "end": end, "idRessource": ressourceId, "idActivite": event.activiteId, "idPatient": event.patientId, "idParcours": event.parcoursId, "id": event.id},
                    url: '<?php echo base_url("Planning/updateEvent"); ?>', //La route
                    dataType: "json", //Le type de donnée de retour
                    success: function (response) {
                        //console.log('Event update with success', response);
                        //console.log(event);
                        constraints();
                        $('#calendar-holder').fullCalendar('refetchEvents');
                    },
                    error: function (e) {
                        console.log('error', e.responseText);
                    }
                });
            }
        });
    });
    
    function displayConstraint(liste) {
        var ul = document.getElementById("ul_constraints");
        $('#ul_constraints').empty();
        var t;
        document.getElementById('constraints').appendChild(ul);
        liste.forEach(ConstraintList);
        function ConstraintList(element) {
            var li = document.createElement('li');
            li.style.color = "red";
            ul.appendChild(li);
            t = document.createTextNode(element);
            li.innerHTML = li.innerHTML + element;
        }
    }

    function displayActivity(liste) {
        var external_events = document.getElementById("activites");
        $('#activites').empty();
        liste.forEach(ActivityList);
        function ActivityList(element) {
            var innerDiv = document.createElement('div');
            innerDiv.className = "fc-event";
            innerDiv.setAttribute("id", element.activite_id + "" + element.patient_id + "" + element.parcours_id);
            innerDiv.setAttribute("activiteID", element.activite_id);
            innerDiv.setAttribute("patientID", element.patient_id);
            innerDiv.setAttribute("parcoursID", element.parcours_id);
            innerDiv.setAttribute("duree", element.duree);
            innerDiv.setAttribute("activite_precedente", element.activite_precedente);
            innerDiv.setAttribute("necessite", element.necessite);
            innerDiv.setAttribute("onclick", "description(id)");
            external_events.appendChild(innerDiv);
            innerDiv.innerHTML = element.nom_activite;
        }

        $('#external-events .fc-event').each(function () {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()),
                activiteId: parseInt($(this).attr('activiteID')),
                patientId: parseInt($(this).attr('patientID')),
                parcoursId: parseInt($(this).attr('parcoursID')),
                duration: $.trim($(this).attr('duree')),
                activite_precedente: $.trim($(this).attr('activite_precedente')),
                necessite: $.trim($(this).attr('necessite'))
            });
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0, //  original position after the drag
                scroll: false
            });
        });
    }

    function description(id) {
        var event = document.getElementById(id);
        $("#eventDescriptionTitle").html(event.innerHTML);
        $("#eventDescriptionInfo").html("Nécessite : " + event.getAttribute("necessite"));
        $("#eventDescriptionPrecedence").html("Activités précédentes : " + event.getAttribute("activite_precedente"));
        $("#eventDescription").dialog({modal: true, title: event.innerHTML, width: 600, height: 300});
    }

    function rechercher() {
        var recherche = document.getElementById("rechercher").value;
        var dateF = $('#calendar-holder').fullCalendar('getDate');
        var date = $.datepicker.formatDate('yy-mm-dd', new Date(dateF));
        //Appel en ajax pour remplir les activités à drop en fonction du jour
        $.ajax({
            type: "POST",
            data: {"date": date, "recherche": recherche},
            url: '<?php echo base_url("Planning/getActiviteAPlanifierRecherche"); ?>', //La route
            dataType: "json", //Le type de donnée de retour
            success: function (data) { //La fonction qui est appelée si la requête a fonctionné.
                //console.log(data);
                displayActivity(data.activite);
            },
            error: function (data) {
                console.log("erreur", data);
            },
        });
    }

    function constraints() {
        var dateF = $('#calendar-holder').fullCalendar('getDate');
        var date = $.datepicker.formatDate('yy-mm-dd', new Date(dateF));

        $.ajax({
            type: "POST",
            data: {"date": date},
            url: '<?php echo base_url("Planning/constraints"); ?>', //La route
            dataType: "json", //Le type de donnée de retour
            success: function (data) { //La fonction qui est appelée si la requête a fonctionné.
                displayConstraint(data);
            },
            error: function (data) {
                console.log("erreur", data);
            },
        });
    }

    function supprimerActivitesPatient() {
        var id = document.getElementById("id").innerHTML;
        var dateF = $('#calendar-holder').fullCalendar('getDate');
        var date = $.datepicker.formatDate('yy-mm-dd', new Date(dateF));
        //console.log(id);
        //Appel en ajax pour remplir les activités à drop en fonction du jour
        $.ajax({
            type: "POST",
            data: {"idPatient": id, "date": date},
            url: '<?php echo base_url("Planning/deleteEventsPatient"); ?>', //La route
            dataType: "json", //Le type de donnée de retour
            success: function (response) { //La fonction qui est appelée si la requête a fonctionné.
                //console.log("Element supprimé");
                $('#calendar-holder').fullCalendar('refetchEvents');
                constraints();
                rechercher();
            },
            error: function (data) {
                console.log("erreur", data);
            },
        });
    }

    function supprimerActivites() {
        var patientId = document.getElementById("id").innerHTML;
        var activiteId = document.getElementById("idActivite").innerHTML;
        var parcoursId = document.getElementById("idParcours").innerHTML;
        $.ajax({
            type: "POST",
            data: {"idActivite": activiteId, "idPatient": patientId, "idParcours": parcoursId},
            url: '<?php echo base_url("Planning/deleteEvent"); ?>', //La route
            dataType: "json", //Le type de donnée de retour
            success: function (response) {
                $('#calendar-holder').fullCalendar('refetchEvents');
                constraints();
                rechercher();
            }
        });
    }
    
    function planificationAuto(){
        var dateF = $('#calendar-holder').fullCalendar('getDate');
        var date = $.datepicker.formatDate('yy-mm-dd', new Date(dateF));
        
        $.ajax({
            type: "POST",
            data: {"date": date},
            url: '<?php echo base_url("Planning/planAuto"); ?>', //La route
            dataType: "json", //Le type de donnée de retour
            success: function (data) { //La fonction qui est appelée si la requête a fonctionné.
                console.log("success");
                $('#calendar-holder').fullCalendar('refetchEvents');
                constraints();
                rechercher();
            },
            error: function (data) {
                console.log("erreur", data);
            },
        });
    }
</script>
}