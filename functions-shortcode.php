<?php
/**
 * Shortcode
 *
 * Categories
 * 113 Community
 * 115 Family & Education
 *
 */

function tna_ebapi_shortcode( $atts ) {

	$a = shortcode_atts( array(
		'organiser' => 2226699547,
		'numberevents' => 6,
		'category' => null
	), $atts);

	$token = get_option('tna_ebapi_token');
	$organiser = $a['organiser'];
	$number = $a['numberevents'];
	$category = '';

	if ($a['category']) {
		$cat = $a['category'];
		$category = '&categories='.$cat;
	}
	if ($token=='') {
		return '<h2>Eventbrite API token not found</h2>';
	}

	return tna_ebapi_events( $organiser, $category, $token, $number );
}
