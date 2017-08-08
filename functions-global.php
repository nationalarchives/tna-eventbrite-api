<?php
/**
 * Global
 *
 */

function tna_ebapi_css()
{
	wp_register_style('ebapi-styles', plugin_dir_url(__FILE__) . 'css/tna-eventbrite-styles.css', '', '1.0', 'all');
	global $post;
	if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'tna-eventbrite')) {
		wp_enqueue_style('ebapi-styles');
	}
}

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
