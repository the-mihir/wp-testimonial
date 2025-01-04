<?php
require_once TSP_PLUGIN_DIR . 'includes/db-functions.php';


$testimonials = tsp_get_all_testimonials();
?>


<div class=" w-75 mt-4">
    <div class="d-flex justify-content-between  align-items-center">
    <h1>Manage Testimonials</h1>
    <a href="admin.php?page=add-new-testimonial" class="btn btn-success">Add New Testimonial</a>
    </div>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Testimonial</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($testimonials): ?>
                <?php foreach ($testimonials as $testimonial): ?>
                    <tr>
                        <td><?php echo $testimonial['id']; ?></td>
                        <td><?php echo esc_html($testimonial['name']); ?></td>
                        <td><?php echo esc_html($testimonial['content']); ?></td>
                        <td><?php echo esc_html($testimonial['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No testimonials found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
