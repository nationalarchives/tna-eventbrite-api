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
		'category' => ''
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

	$events = new Simple_Eventbrite_List;

	return $events->display( $organiser, $category, $token, $number );
}
