<?php
/**
 * Admin
 *
 */

function tna_ebapi_settings_data()
{
	register_setting('tna_ebapi_settings_token', 'tna_token');
}

function tna_ebapi_settings()
{
	add_options_page('Eventbrite settings', 'Eventbrite', 'administrator', 'tna-eventbrite-api',
		'tna_ebapi_settings_page');
}

function tna_ebapi_settings_page()
{
	// admin
	?>
	<div class="wrap">
		<h2>Eventbrite API settings</h2>

		<p>TNA Eventbrite API plugin allows you to list events in a post or page using the [tna-eventbrite] shortcode.
			When editing a page or post, directly insert the shortcode in your text. The basic usage would be something
			like this:</p>

		<p>Default: [tna-eventbrite] (Displays 6 events from default orginiser)</p>

		<p>Specifying organiser ID: [tna-eventbrite organiser=2226699547]</p>

		<p>Specifying number of events displayed: [tna-eventbrite organiser=2226699547 numberevents=12]</p>

		<h3>Organiser ID numbers</h3>

		<p>nationalarchives.eventbrite.co.uk : 2226699547</p>

		<p>nationalarchivesforarchives.eventbrite.co.uk : 8572569853</p>

		<p>nationalarchivesforhighereducation.eventbrite.co.uk : 8627521843</p>

		<p>nationalarchivesforschools.eventbrite.co.uk : </p>

		<p>exploreyourarchive.eventbrite.co.uk : 8537195957</p>

	</div>
	<?php
}