<?php
require_once TSP_PLUGIN_DIR . 'includes/db-functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tsp_add_testimonial_nonce'])) {
    if (wp_verify_nonce($_POST['tsp_add_testimonial_nonce'], 'tsp_add_testimonial')) {
        $name = sanitize_text_field($_POST['testimonial_name']);
        $content = sanitize_textarea_field($_POST['testimonial_content']);

        if (!empty($name) && !empty($content)) {
            $testimonial_id = tsp_save_testimonial_to_db($name, $content);
            if ($testimonial_id) {
                echo '<div class="notice notice-success"><p>Testimonial added successfully!</p></div>';
            } else {
                echo '<div class="notice notice-error"><p>Failed to add testimonial. Please try again.</p></div>';
            }
        } else {
            echo '<div class="notice notice-warning"><p>All fields are required!</p></div>';
        }
    }
}

?>

<div class=" mt-4">
    <h1>Add New Testimonial</h1>
    <form method="post">
    <?php wp_nonce_field('tsp_add_testimonial', 'tsp_add_testimonial_nonce'); ?>
    
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Add New Testimonial</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="testimonial-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="testimonial-name" name="testimonial_name" placeholder="Enter the name of the person" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="testimonial-content" class="form-label">Testimonial</label>
                            <textarea class="form-control" id="testimonial-content" name="testimonial_content" rows="5" placeholder="Enter the testimonial content" required></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Add Testimonial</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</div>
