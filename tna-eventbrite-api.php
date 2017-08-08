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

// Included functions
include 'functions-global.php';
include 'functions-shortcode.php';
include 'functions-admin.php';
include 'functions-eventbrite.php';

// add_action
add_action('wp_enqueue_scripts', 'tna_ebapi_css');
add_action('wp_enqueue_scripts', 'tna_ebapi_js');
add_action('admin_menu', 'tna_ebapi_settings');
add_action('admin_init', 'tna_ebapi_settings_data');

// Shortcode
add_shortcode('tna-eventbrite', 'tna_ebapi_shortcode');
