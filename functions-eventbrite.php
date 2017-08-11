<?php
/**
 * Eventbrite API
 *
 */

class Simple_Eventbrite_List {

	public function url( $organiser, $category, $token ) {

		$url = 'https://www.eventbriteapi.com/v3/events/search/?sort_by=date&organizer.id='.$organiser.$category.'&token='.$token.'&expand=ticket_classes';

		return $url;
	}

	public function get_json( $url ) {

		if ( !class_exists('WP_Http') ) {
			include_once( ABSPATH . WPINC . '/class-http.php');
		}

		$request = new WP_Http;
		$result = $request->request( $url );

		if ( is_wp_error($result) ) {
			$json = null;
		} elseif ( wp_remote_retrieve_response_code($result) == '404' ) {
			$json = null;
		} else {
			$json = $result['body'];
		}

		return $json;
	}

	public function event_status( $status ) {

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

	public function event_online( $online ) {

		$html = '';

		if ( $online == true ) {
			$html = '<div class="online-event"><span>Online event</span></div>';
		}

		return $html;
	}

	public function display( $organiser, $category, $token, $number ) {

		$url = $this->url( $organiser, $category, $token );

		$json = $this->get_json( $url );

		$html = '<div id="tna_ebapi_events" class="track-outbound"><ul class="tna-event-list">';

		if ( $json ) {

			$obj = json_decode( $json );

			$count = count( $obj->events );

			if ( $number > $count ) {
				$number = $count - 1;
			} else {
				$number = $number - 1;
			}

			for ( $i = 0; $i <= $number; $i ++ ) {

				$url     = $obj->events[ $i ]->url;
				$title   = $obj->events[ $i ]->name->text;
				$image   = $obj->events[ $i ]->logo->url;
				$date    = date( 'l j F Y, H:i', strtotime( $obj->events[ $i ]->start->local ) );
				$tickets = $this->event_status( $obj->events[ $i ]->ticket_classes );
				$online  = $this->event_online( $obj->events[ $i ]->online_event );

				$html .= '<li>';

				$html .= '<div class="event-img">' . $online;

				$html .= '<a href="' . $url . '" target="_blank"><img src="' . $image . '" alt="' . $title . '"></a></div>';

				$html .= '<div class="event-text">';

				$html .= '<p><span class="event-date">' . $date . '</span></p>';

				$html .= '<h4><a href="' . $url . '" target="_blank">' . $title . '</a></h4>';

				$html .= '<p class="event-status">' . $tickets . '</p>';

				$html .= '</div></li>';

			}
		} else {

			$html .= '<h2>No events found</h2>';

		}

		$html .= '</ul></div>';

		return $html;
	}
}
