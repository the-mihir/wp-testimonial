<?php
require_once TSP_PLUGIN_DIR . 'includes/db-functions.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .rating-stars {
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 5px;
        }
        .rating-star {
            color: #ddd;
            font-size: 25px;
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating-star.active,
        .rating-star:hover,
        .rating-star:hover ~ .rating-star {
            color: #ffc107;
        }
    </style>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tsp_add_testimonial_nonce'])) {
    if (wp_verify_nonce($_POST['tsp_add_testimonial_nonce'], 'tsp_add_testimonial')) {
        $name = sanitize_text_field($_POST['testimonial_name']);
        $content = sanitize_textarea_field($_POST['testimonial_content']);
        $position = sanitize_text_field($_POST['testimonial_position']);
        $company = sanitize_text_field($_POST['testimonial_company']);
        $rating = intval($_POST['rating']);

        // Handle image upload
        $image_url = '';
        if (!empty($_FILES['testimonial_image']['name'])) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $attachment_id = media_handle_upload('testimonial_image', 0);
            if (!is_wp_error($attachment_id)) {
                $image_url = wp_get_attachment_url($attachment_id);
            }
        }

        if (!empty($name) && !empty($content)) {
            $testimonial_id = tsp_save_testimonial_to_db($name, $content, $position, $company, $rating, $image_url);
            if (!is_wp_error($testimonial_id)) {
                echo '<div class="notice notice-success"><p>Testimonial added successfully!</p></div>';
            } else {
                echo '<div class="notice notice-error"><p>Failed to add testimonial: ' . esc_html($testimonial_id->get_error_message()) . '</p></div>';
            }
        } else {
            echo '<div class="notice notice-warning"><p>Name and content are required fields!</p></div>';
        }
    }
}

?>

<div class=" mt-4">
    <h1>Add New Testimonial</h1>
    <form method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('tsp_add_testimonial', 'tsp_add_testimonial_nonce');?>

    <div class="mt-4">
        <div class="row">
            <div class="col-md-8 col-lg-6">
                <div class=" shadow">
                    <div class="p-4">
                        <div class="mb-4">
                            <label for="testimonial-name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control form-control-lg" id="testimonial-name" name="testimonial_name" placeholder="Enter the person's full name" required>
                        </div>
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="testimonial-position" class="form-label fw-bold">Position</label>
                                    <input type="text" class="form-control" id="testimonial-position" name="testimonial_position" placeholder="e.g. CEO">
                                </div>
                                <div class="col-md-6">
                                    <label for="testimonial-company" class="form-label fw-bold">Company</label>
                                    <input type="text" class="form-control" id="testimonial-company" name="testimonial_company" placeholder="e.g. Company Inc.">
                                </div>
                            </div>
                        </div>


                        <div class="mb-4">
                            <label class="form-label fw-bold">Rating</label>
                            <br>
                            <div class="rating-stars">
                                <span class="rating-star" data-index="5"><i class="fas fa-star"></i></span>
                                <span class="rating-star" data-index="4"><i class="fas fa-star"></i></span>
                                <span class="rating-star" data-index="3"><i class="fas fa-star"></i></span>
                                <span class="rating-star" data-index="2"><i class="fas fa-star"></i></span>
                                <span class="rating-star" data-index="1"><i class="fas fa-star"></i></span>
                            </div>
                            <input type="hidden" name="rating" id="rating-value" value="5">
                            <div class="form-text text-muted">Click to rate from 1 to 5 stars</div>
                        </div>

                        <div class="mb-4">
                            <label for="testimonial-content" class="form-label fw-bold">Testimonial</label>
                            <textarea class="form-control" id="testimonial-content" name="testimonial_content" rows="5" placeholder="Enter the testimonial content" required></textarea>
                            <div class="form-text text-muted">Share the experience and feedback in detail</div>
                        </div>

                        <div class="mb-4">
                            <label for="testimonial-image" class="form-label fw-bold">Profile Image</label>
                            <input type="file" class="form-control" id="testimonial-image" name="testimonial_image" accept="image/*">
                            <div class="form-text text-muted">Recommended size: 200x200 pixels</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>Add Testimonial
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</div>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
jQuery(document).ready(function($) {
    // Set initial rating
    function setInitialRating(rating) {
        $('.rating-star').each(function() {
            if ($(this).data('index') <= rating) {
                $(this).addClass('active');
            }
        });
    }

    // Handle star click
    $('.rating-star').click(function() {
        const rating = $(this).data('index');
        $('#rating-value').val(rating);

        $('.rating-star').removeClass('active');
        $('.rating-star').each(function() {
            if ($(this).data('index') <= rating) {
                $(this).addClass('active');
            }
        });
    });

    // Set default 5-star rating
    setInitialRating(5);
});
</script>
