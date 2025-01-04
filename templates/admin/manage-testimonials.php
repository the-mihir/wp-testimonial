<?php
require_once TSP_PLUGIN_DIR . 'includes/db-functions.php';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $testimonial_id = intval($_GET['id']);
    if (tsp_delete_testimonial($testimonial_id)) {
        echo '<div class="notice notice-success"><p>Testimonial deleted successfully!</p></div>';
    } else {
        echo '<div class="notice notice-error"><p>Error deleting testimonial!</p></div>';
    }
}

// Get all testimonials
$testimonials = tsp_get_all_testimonials();
?>

<div class="wrap mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center bg-primary text-white p-3 mb-4">
                <h4 class="mb-0"><i class="fas fa-comments me-2"></i>Manage Testimonials</h4>
                <a href="<?php echo admin_url('admin.php?page=add-new-testimonial'); ?>" class="btn btn-light">
                    <i class="fas fa-plus-circle me-1"></i> Add New
                </a>
            </div>

            <?php if (!empty($testimonials)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4">SL</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Rating</th>
                                <th>Content</th>
                                <th class="text-end px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sl = 1;
                            foreach ($testimonials as $testimonial): 
                            ?>
                            <tr>
                                <td class="px-4"><?php echo $sl++; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if (!empty($testimonial->image_url)) : ?>
                                            <img src="<?php echo esc_url($testimonial->image_url); ?>" 
                                                 class="rounded-circle me-2" 
                                                 width="32" height="32" 
                                                 alt="Profile">
                                        <?php endif; ?>
                                        <strong><?php echo esc_html($testimonial->name); ?></strong>
                                    </div>
                                </td>
                                <td><?php echo esc_html($testimonial->position); ?></td>
                                <td>
                                    <div class="rating-stars">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <i class="fas fa-star <?php echo ($i <= $testimonial->rating) ? 'text-warning' : ''; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;">
                                        <?php echo esc_html(wp_trim_words($testimonial->content, 15)); ?>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo esc_url(add_query_arg(['page' => 'edit-testimonial', 'id' => $testimonial->id], admin_url('admin.php'))); ?>" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo esc_url(wp_nonce_url(add_query_arg(['page' => 'testimonial-slider-pro', 'action' => 'delete', 'id' => $testimonial->id], admin_url('admin.php')), 'delete_testimonial_' . $testimonial->id)); ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Are you sure you want to delete this testimonial?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="text-center py-5 bg-light">
                    <i class="fas fa-comments text-muted mb-3" style="font-size: 48px;"></i>
                    <h5 class="text-muted">No testimonials found</h5>
                    <p class="mb-3">Start by adding your first testimonial</p>
                    <a href="<?php echo admin_url('admin.php?page=add-new-testimonial'); ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add New Testimonial
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!-- Add Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
