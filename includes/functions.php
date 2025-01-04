<?php

// Handle new testimonial submission
add_action('admin_post_tsp_add_testimonial', 'tsp_save_testimonial');
function tsp_save_testimonial() {
    if (!isset($_POST['tsp_nonce']) || !wp_verify_nonce($_POST['tsp_nonce'], 'tsp_add_testimonial')) {
        wp_die('Invalid nonce!');
    }

    // Save testimonial (replace with your database logic)
    $name = sanitize_text_field($_POST['testimonial_name']);
    $content = sanitize_textarea_field($_POST['testimonial_content']);

    // Example: Output success message
    wp_redirect(admin_url('admin.php?page=testimonial-slider-pro&success=1'));
    exit;
}
