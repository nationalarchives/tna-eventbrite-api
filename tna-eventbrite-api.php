<?php
/**
 * Plugin Name: TNA Eventbrite API
 * Plugin URI: https://github.com/nationalarchives/tna-eventbrite-api
 * Description: This plugin displays events from Eventbrite into a WordPress website.
 * Version: 1.0.1
 * Author: Chris Bishop
 * Author URI: https://github.com/nationalarchives
 * License: GPL2
 */

function tna_ebapi_css()
{
    wp_register_style('ebapi-styles', plugin_dir_url(__FILE__) . 'css/tna-eventbrite-styles.css', '', '1.0', 'all');
    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'tna-eventbrite')) {
        wp_enqueue_style('ebapi-styles');
    }
}

add_action('wp_enqueue_scripts', 'tna_ebapi_css');

function tna_ebapi_js()
{
    wp_register_script('ebapi-script', plugin_dir_url(__FILE__) . 'js/tna-eventbrite-api.js');
    wp_register_script('ebapi-ga', plugin_dir_url(__FILE__) . 'js/tna-eventbrite-ga.js');
    wp_register_script('ebapi-moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.js');
    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'tna-eventbrite')) {
        wp_enqueue_script('ebapi-script', '', '', '', true);
        wp_enqueue_script('ebapi-ga', '', '', '', true);
        wp_enqueue_script('ebapi-moment', '', '', '', true);
    }
}

add_action('wp_enqueue_scripts', 'tna_ebapi_js');

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

add_shortcode('tna-eventbrite', 'tna_ebapi_shortcode');

add_action('admin_menu', 'tna_ebapi_settings');
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

add_action('admin_init', 'tna_ebapi_settings_data');
function tna_ebapi_settings_data()
{
    register_setting('tna_ebapi_settings_token', 'tna_token');
}

?>