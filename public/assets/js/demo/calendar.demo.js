
var handleCalendarDemo = function () {
	// Enable draggable external events
	/*
	var containerEl = document.getElementById('external-events');
	var Draggable = FullCalendar.Draggable;
  
	if (containerEl) {
	  new Draggable(containerEl, {
		itemSelector: '.fc-event',
		eventData: function (eventEl) {
		  return {
			title: eventEl.innerText,
			color: eventEl.getAttribute('data-color')
		  };
		}
	  });
	}*/
  
	// Initialize FullCalendar
	var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        height: 550,
        headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            right: 'prev,next today'
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
        },
        initialView: 'dayGridMonth',
        editable: false,
        droppable: false,
        themeSystem: 'bootstrap',
        eventTimeFormat: false,
        events: 'cases/calendar/events', // URL for fetching events dynamically

        // Event click handler
        eventClick: function(info) {
            let eventId = info.event.id; // Use the event ID to fetch details

            // Show the modal
            $('#viewActivityModal').modal('show');

            // Display loading spinner
            $('#activity-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch event details using AJAX
            $.ajax({
                url: `/cases/case-activity/${eventId}`, // Adjust this to your route to fetch the event details
                type: "GET",
                success: function (response) {
                    let activity = response.data;
                    let case_name = response.case_name;
                    let case_number = response.case_number;

                    const capType = activity.type.charAt(0).toUpperCase() + activity.type.slice(1);

                    let content = `
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Case Number:</strong> ${case_number}</p>
                        <p><strong>Case Name:</strong> ${case_name}</p>
                        <p><strong>Type & Sequence:</strong> ${activity.seq_num}<sup>${activity.seq_suffix}</sup> ${capType}</p>
                        <p><strong>Court Room #:</strong> ${activity.court_room_number}</p>
                        <p><strong>Court Name:</strong> ${activity.court_name}</p>
                        <p><strong>Date:</strong> ${activity.formatted_date}</p>
                        <p><strong>Time:</strong> ${activity.formatted_time}</p>
                        </div>
                        <div class="col-md-6">
                        <p><strong>Mode:</strong> ${activity.hearing_type}</p>
                        <p><strong>Virtual Link:</strong> ${activity.virtual_link ? `<a href="${activity.virtual_link}" target="_blank">Join</a>` : 'N/A'}</p>
                        <p><strong>Court Contacts:</strong> ${activity.court_contacts || 'N/A'}</p>
                        <p><strong>Full Texts:</strong> ${activity.full_texts || 'N/A'}</p>
                        <p><strong>Created At:</strong> ${activity.created_at}</p>
                        <p><strong>Updated At:</strong> ${activity.updated_at}</p>
                        </div>
                    </div>
                    `;

                    // Set the modal title
                    $('#viewActivityModalLabel').text(capType + " Details");

                    // Populate the modal content with the event details
                    $('#activity-content').html(content);
                },
                error: function () {
                    $('#activity-content').html('<div class="text-danger text-center">Error loading activity details.</div>');
                }
            });
        }
    });

    calendar.render();
};
  
  // Initialize on document ready
  var Calendar = function () {
	"use strict";
	return {
	  init: function () {
		handleCalendarDemo();
	  }
	};
  }();
  
  $(document).ready(function () {
	Calendar.init();
  });
  
/*
var handleCalendarDemo = function() {
	// external events
	var containerEl = document.getElementById('external-events');
  var Draggable = FullCalendar.Interaction.Draggable;
	new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function(eventEl) {
      return {
        title: eventEl.innerText,
        color: eventEl.getAttribute('data-color')
      };
    }
  });
  
  // fullcalendar
  
  var d = new Date();
	var month = d.getMonth() + 1;
	    month = (month < 10) ? '0' + month : month;
	var year = d.getFullYear();
	var day = d.getDate();
	var today = moment().startOf('day');
  var calendarElm = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarElm, {
    headerToolbar: {
      left: 'dayGridMonth,timeGridWeek,timeGridDay',
      center: 'title',
      right: 'prev,next today'
    },
    buttonText: {
    	today:    'Today',
			month:    'Month',
			week:     'Week',
			day:      'Day'
    },
    initialView: 'dayGridMonth',
    editable: true,
    droppable: true,
  	themeSystem: 'bootstrap',
  	events: [{
			title: 'Trip to Kenya',
			start: year + '-'+ month +'-01',
			end: year + '-'+ month +'-05',
			color: app.color.success
		},{
			title: 'Meet with Irene Wong',
			start: year + '-'+ month +'-02T06:00:00',
			color: app.color.blue
		},{
			title: 'Mobile Apps Brainstorming: uurj',
			start: year + '-'+ month +'-10',
			end: year + '-'+ month +'-12',
			color: app.color.pink
		},{
			title: 'Stonehenge, Windsor Castle, Oxford',
			start: year + '-'+ month +'-05T08:45:00',
			end: year + '-'+ month +'-06T18:00',
			color: app.color.indigo
		},{
			title: 'Paris Trip. Good',
			start: year + '-'+ month +'-12',
			end: year + '-'+ month +'-16'
		},{
			title: 'Domain name due. Really',
			start: year + '-'+ month +'-15',
			color: app.color.blue
		},{
			title: 'Cambridge Trip',
			start: year + '-'+ month +'-19'
		},{
			title: 'Visit Apple Company',
			start: year + '-'+ month +'-22T05:00:00',
			color: app.color.success
		},{
			title: 'Exercise Class',
			start: year + '-'+ month +'-22T07:30:00',
			color: app.color.orange
		},{
			title: 'Live Recording',
			start: year + '-'+ month +'-22T03:00:00',
			color: app.color.blue
		},{
			title: 'Announcement',
			start: year + '-'+ month +'-22T15:00:00',
			color: app.color.red
		},{
			title: 'Dinner',
			start: year + '-'+ month +'-22T18:00:00'
		},{
			title: 'New Android App Discussion',
			start: year + '-'+ month +'-25T08:00:00',
			end: year + '-'+ month +'-25T10:00:00',
			color: app.color.red
		},{
			title: 'Marketing Plan Presentation',
			start: year + '-'+ month +'-25T12:00:00',
			end: year + '-'+ month +'-25T14:00:00',
			color: app.color.blue
		},{
			title: 'Chase due',
			start: year + '-'+ month +'-26T12:00:00',
			color: app.color.orange
		},{
			title: 'Heartguard',
			start: year + '-'+ month +'-26T08:00:00',
			color: app.color.orange
		},{
			title: 'Lunch with Richard',
			start: year + '-'+ month +'-28T14:00:00',
			color: app.color.blue
		},{
			title: 'Web Hosting due. Really',
			start: year + '-'+ month +'-30',
			color: app.color.blue
		}]
  });
  
	calendar.render();
};

var Calendar = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleCalendarDemo();
		}
	};
}();

$(document).ready(function() {
	Calendar.init();
});

*/