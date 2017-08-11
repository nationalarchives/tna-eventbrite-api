<?php
/**
 * Eventbrite API
 *
 */

function tna_ebapi_url( $organiser, $category, $token ) {

	$url = 'https://www.eventbriteapi.com/v3/events/search/?sort_by=date&organizer.id='.$organiser.$category.'&token='.$token.'&expand=ticket_classes';

	return $url;

}

function tna_ebapi_get_eventbrite_json( $url ) {

	if ( !class_exists('WP_Http') ) {
		include_once( ABSPATH . WPINC . '/class-http.php');
	}

	$request = new WP_Http;
	$result = $request->request( $url );
	$json = $result['body'];

	return $json;
}

function tna_ebapi_events( $url, $number ) {

	$json = tna_ebapi_get_eventbrite_json( $url );

	$obj = json_decode($json);

	$count = count($obj->events);

	if ($number > $count) {
		$number = $count-1;
	} else {
		$number = $number-1;
	}

	$html = '<div id="tna_ebapi_events" class="track-outbound"><ul class="tna-event-list">';

	for ( $i=0 ; $i<=$number ; $i++ ) {

		$url        = $obj->events[$i]->url;
		$title      = $obj->events[$i]->name->text;
		$image      = $obj->events[$i]->logo->url;
		$date       = date('l j F Y, H:i', strtotime($obj->events[$i]->start->local));
		$status     = $obj->events[$i]->ticket_classes;
		$tickets    = tna_ebapi_event_status( $status );
		$online     = tna_ebapi_event_online( $obj->events[$i]->online_event );

		$html .= '<li>';

		$html .= '<div class="event-img">'.$online;

		$html .= '<a href="'.$url.'" target="_blank"><img src="'.$image.'" alt="'.$title.'"></a></div>';

		$html .= '<div class="event-text">';

		$html .= '<p><span class="event-date">'.$date.'</span></p>';

		$html .= '<h4><a href="'.$url.'" target="_blank">'.$title.'</a></h4>';

		$html .= '<p class="event-status">'.$tickets.'</p>';

		$html .= '</div></li>';

	}

	$html .= '</ul></div>';

	return $html;
}

function tna_ebapi_event_status( $status ) {

	$tickets = '';

	if ($status) {

		$count = count($status);

		for ($tc = 0; $tc < $count; $tc++) {

			if ($status[$tc]->on_sale_status == 'AVAILABLE') {
				$tickets = ($status[$tc]->free) ? 'FREE' : 'PAID';
				break;
			} else {
				$tickets = 'FULLY BOOKED';
			}
		}
	}

	return $tickets;
}

function tna_ebapi_event_online( $online ) {

	$html = '';

	if ( $online == true ) {
		$html = '<div class="online-event"><span>Online event</span></div>';
	}

	return $html;
}