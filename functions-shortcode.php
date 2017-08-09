<?php
/**
 * Shortcode
 *
 */

function tna_ebapi_shortcode($atts)
{
	$a = shortcode_atts( array(
		'organiser' => 2226699547,
		'numberevents' => 6,
		'category' => null
	), $atts);

	$token = get_option('tna_ebapi_token');
	$organiser = $a['organiser'];
	$category = '';

	if ($a['category']) {
		$cat = $a['category'];
		$category = '&categories='.$cat;
	}
	if ($token=='') {
		return '<h2>Eventbrite API token not found</h2>';
	}

	$url = 'https://www.eventbriteapi.com/v3/events/search/?organizer.id='.$organiser.$category.'&token='.$token.'&expand=ticket_classes';

	return tna_ebapi_events( $url );
}
