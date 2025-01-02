<?php
/*
Plugin Name: WP Testimonial Plugin
Description: A custom Testimonial slider plugin for WordPress.
Version: 1.0
Author: Mihir Das
*/

// সরাসরি অ্যাক্সেস প্রতিরোধ
if ( !defined( 'ABSPATH' ) ) exit;

// ফাইল ইমপোর্ট
require_once plugin_dir_path( __FILE__ ) . 'includes/functions.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-slider.php';

// অ্যাডমিন মেনু যোগ করা
if ( is_admin() ) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/admin/admin-menu.php';
}

