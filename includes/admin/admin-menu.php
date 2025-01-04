<?php

require_once TSP_PLUGIN_DIR . 'includes/db-functions.php';
wp_enqueue_style('bootstrap-css', TSP_PLUGIN_URL . 'assets/css/bootstrap.min.css', [], '5.3.0');

// Hook to add admin menu
add_action('admin_menu', 'tsp_register_admin_menu');

function tsp_register_admin_menu() {
    add_menu_page(
        'Testimonial Slider',               // Page title
        'Testimonial Slider',               // Menu title
        'manage_options',                   // Capability
        'testimonial-slider-pro',           // Menu slug
        'tsp_manage_testimonials_page',     // Callback for main menu
        'dashicons-format-quote',           // Icon
        20                                  // Position
    );

    add_submenu_page(
        'testimonial-slider-pro',
        'Add New Testimonial',
        'Add New',
        'manage_options',
        'add-new-testimonial',
        'tsp_add_new_testimonial_page'
    );
}

// Include page templates
function tsp_manage_testimonials_page() {
    include TSP_PLUGIN_DIR . 'templates/admin/manage-testimonials.php';
}

function tsp_add_new_testimonial_page() {
    include TSP_PLUGIN_DIR . 'templates/admin/add-new-testimonial.php';
}
