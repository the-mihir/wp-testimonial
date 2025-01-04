<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Save testimonial to database
 * 
 * @param string $name Name of the person
 * @param string $content Testimonial content
 * @param string $position Position (optional)
 * @param string $company Company (optional)
 * @param int $rating Rating 1-5 (optional)
 * @param string $image_url Profile image URL (optional)
 * @return int|WP_Error Returns insert ID on success, WP_Error on failure
 */
function tsp_save_testimonial_to_db($name, $content, $position = '', $company = '', $rating = 5, $image_url = '') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    // Validate required fields
    if (empty($name) || empty($content)) {
        return new WP_Error(
            'missing_fields',
            __('Name and content are required fields', 'testimonial-slider-pro')
        );
    }

    // Validate rating range
    $rating = max(1, min(5, intval($rating)));

    // Prepare data with sanitization
    $data = array(
        'name'      => wp_strip_all_tags(sanitize_text_field($name)),
        'content'   => wp_kses_post($content),
        'position'  => wp_strip_all_tags(sanitize_text_field($position)),
        'company'   => wp_strip_all_tags(sanitize_text_field($company)),
        'rating'    => $rating,
        'image_url' => empty($image_url) ? '' : esc_url_raw($image_url)
    );

    $format = array(
        '%s', // name
        '%s', // content
        '%s', // position
        '%s', // company
        '%d', // rating
        '%s'  // image_url
    );

    // Start transaction
    $wpdb->query('START TRANSACTION');

    try {
        $result = $wpdb->insert($table_name, $data, $format);

        if ($result === false) {
            throw new Exception($wpdb->last_error);
        }

        $insert_id = $wpdb->insert_id;
        $wpdb->query('COMMIT');
        return $insert_id;

    } catch (Exception $e) {
        $wpdb->query('ROLLBACK');
        return new WP_Error(
            'db_insert_error',
            __('Failed to save testimonial', 'testimonial-slider-pro'),
            $e->getMessage()
        );
    }
}

/**
 * Update existing testimonial
 * 
 * @param int $id Testimonial ID
 * @param string $name Name of the person
 * @param string $content Testimonial content
 * @param string $position Position (optional)
 * @param string $company Company (optional)
 * @param int $rating Rating 1-5 (optional)
 * @param string $image_url Profile image URL (optional)
 * @return bool|WP_Error Returns true on success, WP_Error on failure
 */
function tsp_update_testimonial($id, $name, $content, $position = '', $company = '', $rating = 5, $image_url = '') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    // Validate ID
    $id = absint($id);
    if (!$id) {
        return new WP_Error(
            'invalid_id',
            __('Invalid testimonial ID', 'testimonial-slider-pro')
        );
    }

    // Validate required fields
    if (empty($name) || empty($content)) {
        return new WP_Error(
            'missing_fields',
            __('Name and content are required fields', 'testimonial-slider-pro')
        );
    }

    // Validate rating range
    $rating = max(1, min(5, intval($rating)));

    // Prepare data with sanitization
    $data = array(
        'name'      => wp_strip_all_tags(sanitize_text_field($name)),
        'content'   => wp_kses_post($content),
        'position'  => wp_strip_all_tags(sanitize_text_field($position)),
        'company'   => wp_strip_all_tags(sanitize_text_field($company)),
        'rating'    => $rating,
        'image_url' => empty($image_url) ? '' : esc_url_raw($image_url)
    );

    $format = array(
        '%s', // name
        '%s', // content
        '%s', // position
        '%s', // company
        '%d', // rating
        '%s'  // image_url
    );

    // Start transaction
    $wpdb->query('START TRANSACTION');

    try {
        $result = $wpdb->update(
            $table_name,
            $data,
            array('id' => $id),
            $format,
            array('%d')
        );

        if ($result === false) {
            throw new Exception($wpdb->last_error);
        }

        $wpdb->query('COMMIT');
        return true;

    } catch (Exception $e) {
        $wpdb->query('ROLLBACK');
        return new WP_Error(
            'db_update_error',
            __('Failed to update testimonial', 'testimonial-slider-pro'),
            $e->getMessage()
        );
    }
}

/**
 * Get all testimonials from database
 * 
 * @return array|WP_Error Array of testimonials or WP_Error on failure
 */
function tsp_get_all_testimonials() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    try {
        $query = "SELECT * FROM $table_name ORDER BY created_at DESC";
        $results = $wpdb->get_results($query);

        if ($wpdb->last_error) {
            throw new Exception($wpdb->last_error);
        }

        return $results ?: array();

    } catch (Exception $e) {
        return new WP_Error(
            'db_query_error',
            __('Failed to fetch testimonials', 'testimonial-slider-pro'),
            $e->getMessage()
        );
    }
}

/**
 * Get single testimonial by ID
 * 
 * @param int $id Testimonial ID
 * @return object|WP_Error|null Testimonial object, null if not found, or WP_Error on failure
 */
function tsp_get_testimonial($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    // Validate ID
    $id = absint($id);
    if (!$id) {
        return new WP_Error(
            'invalid_id',
            __('Invalid testimonial ID', 'testimonial-slider-pro')
        );
    }

    try {
        $query = $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            $id
        );

        $result = $wpdb->get_row($query);

        if ($wpdb->last_error) {
            throw new Exception($wpdb->last_error);
        }

        return $result;

    } catch (Exception $e) {
        return new WP_Error(
            'db_query_error',
            __('Failed to fetch testimonial', 'testimonial-slider-pro'),
            $e->getMessage()
        );
    }
}

/**
 * Delete testimonial by ID
 * 
 * @param int $id Testimonial ID
 * @return bool|WP_Error True on success, WP_Error on failure
 */
function tsp_delete_testimonial($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'testimonials';

    // Validate ID
    $id = absint($id);
    if (!$id) {
        return new WP_Error(
            'invalid_id',
            __('Invalid testimonial ID', 'testimonial-slider-pro')
        );
    }

    // Get the testimonial to delete its image
    $testimonial = tsp_get_testimonial($id);
    if (is_wp_error($testimonial)) {
        return $testimonial;
    }

    // Start transaction
    $wpdb->query('START TRANSACTION');

    try {
        // Delete the testimonial
        $result = $wpdb->delete(
            $table_name,
            array('id' => $id),
            array('%d')
        );

        if ($result === false) {
            throw new Exception($wpdb->last_error);
        }

        // Delete the associated image if it exists
        if (!empty($testimonial->image_url)) {
            $attachment_id = attachment_url_to_postid($testimonial->image_url);
            if ($attachment_id) {
                wp_delete_attachment($attachment_id, true);
            }
        }

        $wpdb->query('COMMIT');
        return true;

    } catch (Exception $e) {
        $wpdb->query('ROLLBACK');
        return new WP_Error(
            'db_delete_error',
            __('Failed to delete testimonial', 'testimonial-slider-pro'),
            $e->getMessage()
        );
    }
}
