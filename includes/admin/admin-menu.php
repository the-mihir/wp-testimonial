<?php

require_once TSP_PLUGIN_DIR . 'includes/db-functions.php';
wp_enqueue_style('bootstrap-css', TSP_PLUGIN_URL . 'assets/css/bootstrap.min.css', [], '5.3.0');
wp_enqueue_style('custom-admin-css', TSP_PLUGIN_URL . 'assets/css/custom-admin.css', ['bootstrap-css']);

// Hook to add admin menu
add_action('admin_menu', 'tsp_register_admin_menu');
add_action('admin_init', 'tsp_handle_admin_actions');

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

    // Hidden submenu pages for edit and delete
    add_submenu_page(
        null,                              // No parent menu
        'Edit Testimonial',                // Page title
        'Edit Testimonial',                // Menu title
        'manage_options',                  // Capability
        'edit-testimonial',                // Menu slug
        'tsp_edit_testimonial_page'        // Callback function
    );
}

// Handle admin actions (edit/delete)
function tsp_handle_admin_actions() {
    if (isset($_GET['page']) && $_GET['page'] === 'manage-testimonials' && 
        isset($_GET['action']) && $_GET['action'] === 'delete' && 
        isset($_GET['id'])) {
        
        $testimonial_id = intval($_GET['id']);
        $nonce = $_GET['_wpnonce'];

        if (wp_verify_nonce($nonce, 'delete_testimonial_' . $testimonial_id)) {
            $result = tsp_delete_testimonial($testimonial_id);
            
            if (!is_wp_error($result)) {
                wp_redirect(add_query_arg('deleted', 'true', admin_url('admin.php?page=testimonial-slider-pro')));
                exit;
            } else {
                wp_redirect(add_query_arg('error', 'delete_failed', admin_url('admin.php?page=testimonial-slider-pro')));
                exit;
            }
        }
    }
}

// Include page templates
function tsp_manage_testimonials_page() {
    include TSP_PLUGIN_DIR . 'templates/admin/manage-testimonials.php';
}

function tsp_add_new_testimonial_page() {
    include TSP_PLUGIN_DIR . 'templates/admin/add-new-testimonial.php';
}

function tsp_edit_testimonial_page() {
    include TSP_PLUGIN_DIR . 'templates/admin/edit-testimonial.php';
}
