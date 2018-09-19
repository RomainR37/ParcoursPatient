var aa = $("#mytimeline");
if(!aa.size())
    var data = undefined;

    var timeline = undefined;
//    var data = undefined;

    google.load("visualization", "1");

    // Set callback to run when API is loaded
    google.setOnLoadCallback(drawVisualization);

    // Called when the Visualization API is loaded.
    function drawVisualization() {
        // specify options
        var options = {
            width:  "100%",
            height: "99%",
            layout: "box",
            axisOnTop: true,
			dragAreaWidth: 0,
            groupMinHeight: 35,
            step: 5,
            eventMargin: 0,  // minimal margin between events
            eventMarginAxis: 0, // minimal margin beteen events and the axis
            editable: false,    // Empêche de rajouter des activités (Read-Only)
			selectable: true,
			timeChangeable: true,
            groupsChangeable: true, // A améliorer pour ne changer que vers une ressource adéquate
            showNavigation: false,
            max: new Date(new Date().setDate(new Date().getDate()+2)), // Deux jours après
            min: new Date(new Date().setDate(new Date().getDate()-1)), // Un jour avant
            zoomMax: 1000 * 60 * 60 * 24, // Max : plage de 4 heures
            zoomMin: 1000 * 60 * 60,      // Min : plage de 30 minutes
            zoomable: true
        };

        // Instantiate our timeline object.
        timeline = new links.Timeline(document.getElementById('mytimeline'), options);

        // register event listeners
        google.visualization.events.addListener(timeline, 'select', onSelect);
        // Draw our timeline with the created data and options
        timeline.draw(data);
    }

    function getRandomName() {
        var names = ["Algie", "Barney", "Grant", "Mick", "Langdon"];

        var r = Math.round(Math.random() * (names.length - 1));
        return names[r];
    }

    function getSelectedRow() {
        var row = undefined;
        var sel = timeline.getSelection();
        if (sel.length) {
            if (sel[0].row != undefined) {
                row = sel[0].row;
            }
        }
        return row;
    }

    function strip(html)
    {
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent||tmp.innerText;
    }

    function getMonday(d) {
      d = new Date(d);
      var day = d.getDay(),
          diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
      return new Date(d.setDate(diff));
    }

    // Make a callback function for the select event
	
    var onSelect = function (event) {
        var row = getSelectedRow();
        if(row !== undefined) // Vérifier qu'on sélectionne une activité
            $(".alert").show().empty().append(data[row]["content"]);
        /**
        var content = data.getValue(row, 2);
        var availability = strip(content);
        var newAvailability = prompt("Enter status\n\n" +
                "Choose from: Available, Unavailable, Maybe", availability);
        if (newAvailability != undefined) {
            var newContent = newAvailability;
            data.setValue(row, 2, newContent);
            data.setValue(row, 4, newAvailability.toLowerCase());
            timeline.draw(data);
        }
        **/
    };


    var onNew = function () {
        alert("Clicking this NEW button should open a popup window where " +
                "a new status event can be created.\n\n" +
                "Apperently this is not yet implemented...");
    };
