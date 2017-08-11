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

	public function event_image( $online, $url, $image, $title ) {

		$html = '<div class="event-img">%s<a href="%s" target="_blank"><img src="%s" alt="%s"></a></div>';

		return sprintf( $html, $online, $url, $image, $title );
	}

	public function event_text( $date, $url, $title, $tickets ) {

		$html = '<div class="event-text"><p><span class="event-date">%s</span></p><h4><a href="%s" target="_blank">%s</a></h4><p class="event-status">%s</p></div>';

		return sprintf( $html, $date, $url, $title, $tickets );
	}

	public function display( $organiser, $category, $token, $number ) {

		$url    = $this->url( $organiser, $category, $token );
		$json   = $this->get_json( $url );

		$html   = '<div id="tna_ebapi_events" class="track-outbound"><ul class="tna-event-list">';

		if ( $json ) {

			$obj = json_decode( $json );

			if ( $obj->status_code == 400 || $obj->status_code == 401 ) {

				$error = $obj->error_description;

				$html .= '<h2>API error '.$obj->status_code.'</h2>';
				$html .= '<p>'.$error.'</p>';

			} else {

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

					$html   .= '<li>';
					$html   .= $this->event_image( $online, $url, $image, $title );
					$html   .= $this->event_text( $date, $url, $title, $tickets );
					$html   .= '</li>';

				}
			}
		} else {

			$html .= '<h2>No events found</h2>';

		}

		$html .= '</ul></div>';

		return $html;
	}
}
