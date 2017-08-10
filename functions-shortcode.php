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
	$number = $a['numberevents'];
	$category = '';

	if ($a['category']) {
		$cat = $a['category'];
		$category = '&categories='.$cat;
	}
	if ($token=='') {
		return '<h2>Eventbrite API token not found</h2>';
	}

	$url = tna_ebapi_url( $organiser, $category, $token );

	return tna_ebapi_events( $url, $number );
}
