$(document).ready(function() {
    //anon oauth token
    var token = '5VVFLKAPZUXJSKQ3QTBG';
    //org id
    var organizer = events.getAttribute('data-org-id');
    //number of events displayed
    var n = events.getAttribute('data-number-events');
    var $events = $("#events");
    $events.html("<i>Loading events, please stand by...</i>");

    $.get('https://www.eventbriteapi.com/v3/events/search/?sort_by=date&organizer.id=' + organizer + '&token=' + token + '&expand=ticket_classes', function(res) {
        if (res.events.length) {
            var s = "<ul class='tna-event-list'>";
            for (var i = 0; i < n; i++) {
                var event = res.events[i];
                var eventTime = moment(event.start.local).format('dddd Do MMMM YYYY, h:mm a');
                console.dir(event);
                if(event.logo) {
			        var image = "<img src='" + event.logo.url + "' alt='" + event.name.text + "'>";
                } else {
		        	image = '';
		        }
		        if(event.ticket_classes.length) {
                    var booking = (event.ticket_classes[0]['on_sale_status']);
                    if (booking == 'AVAILABLE') {
                        var free = (event.ticket_classes[0]['free']) ? 'FREE' : '';
                    } else {
                        free = 'FULLY BOOKED'
                    }
		        } else {
		        	free = '';
		        }
                s += "<li>" + image + "<br><a href='" + event.url + "' alt='" + event.name.text + "'>" + event.name.text + "</a> " + free + "<br><span class='text-small'>" + eventTime + "</span></li>";
            }
            s += "</ul>";
            $events.html(s);
        } else {
            $events.html("Sorry, there are no upcoming events.");
        }
    });
});