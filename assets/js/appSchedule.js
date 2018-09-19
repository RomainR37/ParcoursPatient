// var aa = $("#myschedule");
// if(aa.size())
// {
var aa = $("#myschedule");
if(aa.size()){
	var now = moment().add(week, 'week');
	$('#myschedule').easycal({
		startDate : now.format("DD-MM-YYYY"), // OR 31/10/2104
		timeFormat : 'HH:mm',
		columnDateFormat : 'dddd, DD MMM',
		minTime : '08:00:00',
		maxTime : '18:00:00',
		slotDuration : 20,
		timeGranularity : 5,
		
		dayClick : function(el, startTime){
			console.log('Slot selected: ' + startTime);
		},
		eventClick : function(eventId){
			console.log('Event was clicked with id: ' + eventId);
		},

		events : getEvents(),
		
		overlapColor : '#FF0',
		overlapTextColor : '#000',
		overlapTitle : 'Multiple'
	});
}