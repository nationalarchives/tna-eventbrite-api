<?php
/**
 * Shortcode
 *
 */

function tna_ebapi_shortcode($atts)
{
	extract(shortcode_atts(array(
		'organiser' => 2226699547,
		'numberevents' => 6
	), $atts));
	switch ($organiser) {
		case '8572569853':
			$url = 'http://nationalarchivesforarchives.eventbrite.co.uk/';
			break;
		case '8627521843':
			$url = 'http://nationalarchivesforhighereducation.eventbrite.co.uk/';
			break;
		case '8537195957':
			$url = 'exploreyourarchive.eventbrite.co.uk/';
			break;
		default:
			$url = 'http://nationalarchives.eventbrite.co.uk/';
	}

	return '<div id="events" class="track-outbound" data-org-id="' . $organiser . '" data-number-events="' . $numberevents . '"></div>
	        <div class="visit-eventbrite"><a href="' . $url . '" target="_blank" title="The National Archives events"><noscript>Please visit our events page on Eventbrite</noscript></a></div>';
}
