<?php
/**
 * Global
 *
 */

function tna_ebapi_css() {
	wp_register_style('ebapi-styles', make_url_https( plugin_dir_url(__FILE__) ) . 'css/eventbrite.css.min', '', 2.1, 'all');
	global $post;
	if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'tna-eventbrite')) {
		wp_enqueue_style('ebapi-styles');
	}
}

function make_url_https( $url ) {

    if ( strpos( $url, 'http:' ) !== false ) {
        $url = str_replace('http:', 'https:', $url);
        return $url;
    }
    return $url;
}