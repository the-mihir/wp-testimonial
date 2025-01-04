<?php

if (!defined('ABSPATH')) {
    exit;
}

// Save testimonial to database
function tsp_save_testimonial_to_db($name, $content) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    $wpdb->insert(
        $table_name,
        [
            'name'    => $name,
            'content' => $content,
        ],
        [
            '%s', // String type for name
            '%s', // String type for content
        ]
    );

    return $wpdb->insert_id; // Returns the ID of the inserted row
}

// Fetch testimonials from database
function tsp_get_all_testimonials() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    return $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC", ARRAY_A);
}
