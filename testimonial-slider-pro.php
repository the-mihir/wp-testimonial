<?php
/**
 * Plugin Name: Testimonial Slider Pro
 * Plugin URI: https://github.com/the-mihir/wp-testimonial
 * Description: This plugin allows you to create a testimonial slider with a smooth swiping experience, perfect for showcasing customer feedback and reviews.
 * Version: 1.0.0
 * Author: Mihir Das
 * Author URI: https://github.com/the-mihir
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * @package TestimonialSliderPro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TSP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TSP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include admin menu
require_once TSP_PLUGIN_DIR . 'includes/admin/admin-menu.php';

// Enqueue admin assets
function tsp_enqueue_admin_assets($hook) {
    if (strpos($hook, 'testimonial-slider-pro') !== false) {
        // Bootstrap
        wp_enqueue_style('bootstrap-css', TSP_PLUGIN_URL . 'assets/css/bootstrap.min.css', [], '5.3.0');
        wp_enqueue_script('bootstrap-js', TSP_PLUGIN_URL . 'assets/js/bootstrap.bundle.min.js', ['jquery'], '5.3.0', true);

        // Custom styles and scripts
        wp_enqueue_style('custom-admin-css', TSP_PLUGIN_URL . 'assets/css/custom-admin.css', ['bootstrap-css']);
        wp_enqueue_script('custom-admin-js', TSP_PLUGIN_URL . 'assets/js/custom-admin.js', ['bootstrap-js']);
    }
}
add_action('admin_enqueue_scripts', 'tsp_enqueue_admin_assets');

register_activation_hook(__FILE__, 'tsp_create_testimonials_table');

function tsp_enqueue_frontend_assets() {
    // Enqueue Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css');

    // Enqueue Swiper JS
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js', [], null, true);

    // Custom Styles for Swiper Slider
    wp_enqueue_style('tsp-swiper-style', TSP_PLUGIN_URL . 'assets/css/swiper-style.css');
    wp_enqueue_script('tsp-swiper-script', TSP_PLUGIN_URL . 'assets/js/swiper-init.js', ['swiper-js'], null, true);
}
add_action('wp_enqueue_scripts', 'tsp_enqueue_frontend_assets');

function tsp_create_testimonials_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        position varchar(100),
        company varchar(100),
        rating tinyint(1) DEFAULT 5,
        content text NOT NULL,
        image_url varchar(255),
        created_at timestamp DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function tsp_testimonial_slider_shortcode() {
    // Get testimonials from the database
    $testimonials = tsp_get_all_testimonials();
    if (!$testimonials) {
        return '<p>No testimonials found.</p>';
    }

    // Start the Swiper slider container
    $output = '<div class="swiper-container container">';
    $output .= '<div class="swiper-wrapper">';

    // Loop through the testimonials and add them to the Swiper slider
    foreach ($testimonials as $testimonial) {
        $output .= '<div class="swiper-slide">';
        $output .= '<div class="testimonial-card">';
        
        // Image
        if (!empty($testimonial->image_url)) {
            $output .= sprintf(
                '<img src="%s" alt="%s" class="testimonial-image">',
                esc_url($testimonial->image_url),
                esc_attr(sprintf(__('Photo of %s', 'testimonial-slider-pro'), $testimonial->name))
            );
        }

        // Content
        $output .= sprintf('<p class="testimonial-content">%s</p>', esc_html($testimonial->content));
        
        // Rating
        $output .= '<div class="rating">';
        for ($i = 1; $i <= 5; $i++) {
            $star_class = $i <= $testimonial->rating ? 'active' : '';
            $output .= sprintf('<span class="star %s"><i class="fas fa-star"></i></span>', $star_class);
        }
        
        // Author info
        $output .= sprintf('<p class="testimonial-name">%s</p>', esc_html($testimonial->name));
        if (!empty($testimonial->position)) {
            $output .= sprintf('<p class="testimonial-position">%s</p>', esc_html($testimonial->position));
        }
        if (!empty($testimonial->company)) {
            $output .= sprintf('<p class="testimonial-company">%s</p>', esc_html($testimonial->company));
        }

        $output .= '</div>'; // Close rating div
        $output .= '</div>'; // Close testimonial-card
        $output .= '</div>'; // Close swiper-slide
    }

    // End the Swiper slider container
    $output .= '</div>';  // End swiper-wrapper
    $output .= '<div class="swiper-pagination"></div>';
    $output .= '<div class="swiper-button-next"></div>';
    $output .= '<div class="swiper-button-prev"></div>';
    $output .= '</div>';  // End swiper-container

    return $output;
}
add_shortcode('testimonial_slider', 'tsp_testimonial_slider_shortcode');
