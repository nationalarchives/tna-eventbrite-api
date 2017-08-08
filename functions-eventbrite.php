<?php
/**
 * Eventbrite API
 *
 */

function tna_ebapi_get_eventbrite_json( $url ) {

	if ( !class_exists('WP_Http') ) {
		include_once( ABSPATH . WPINC . '/class-http.php');
	}

	$request = new WP_Http;
	$result = $request->request( $url );
	$json = $result['body'];

	return $json;
}

function tna_ebapi_events( $url ) {

	$json = tna_ebapi_get_eventbrite_json( $url );

	$obj = json_decode($json);

	$html = '<div id="tna_ebapi_events" class="track-outbound">';

	foreach ($obj->events as $event) {

		$html .= $event->name->text . '<br>';
	}

	$html .= '</div>';

	return $html;
}
