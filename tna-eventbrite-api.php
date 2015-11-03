<?php
/**
 * Plugin Name: TNA Eventbrite API
 * Plugin URI: https://github.com/nationalarchives/tna-eventbrite-api
 * Description: This plugin displays events from Eventbrite into a WordPress website.
 * Version: 1.0.0
 * Author: Chris Bishop
 * Author URI: https://github.com/nationalarchives
 * License: GPL2
 */

add_action('wp_footer', 'tna_ebapi_js');
function tna_ebapi_js()
{
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ); ?>js/tna-eventbrite-api.js"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ); ?>js/tna-eventbrite-ga.js"></script>
    <?php
}

function tna_ebapi_shortcode($atts)
{
    extract(shortcode_atts(array(
        'organiser' => 2226699547,
        'numberevents' => 3
    ), $atts));
    if ($organiser == 2226699547) {
        $url = 'http://nationalarchives.eventbrite.co.uk/';
    }

    return '<div id="events" class="track-outbound" data-org-id="' . $organiser . '" data-number-events="' . $numberevents . '"></div>
	        <div class="no-js"><a href="' . $url . '"></a></div>';
}

add_shortcode('tna-eventbrite', 'tna_ebapi_shortcode');

?>