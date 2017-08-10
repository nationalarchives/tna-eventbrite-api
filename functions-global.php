<?php
/**
 * Global
 *
 */

function tna_ebapi_css() {
	wp_register_style('ebapi-styles', plugin_dir_url(__FILE__) . 'css/eventbrite.css.min', '', 2.0, 'all');
	global $post;
	if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'tna-eventbrite')) {
		wp_enqueue_style('ebapi-styles');
	}
}

function tna_ebapi_js() {
	wp_register_script('ebapi-ga', plugin_dir_url(__FILE__) . 'js/tna-eventbrite-ga.js', array(), 2.0, true);
	global $post;
	if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'tna-eventbrite')) {
		wp_enqueue_script('ebapi-ga');
	}
}
