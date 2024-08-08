<?php
//  custom meta box for course 
function custom_course_details_meta()
{
    add_meta_box(
        'custom_course_tip_meta',
        'Bundle course Tip',
        'bundle_course_tip',
        'course',
        'normal',
        'high'
    );
    add_meta_box(
        'featured_meta',
        'Featured Tip',
        'featured_details',
        'course',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'custom_course_details_meta');

// Callback function to render the meta box
function bundle_course_tip($post)
{
    // Retrieve existing meta values
    $bundle_course_tip = get_post_meta($post->ID, 'custom_course_tip_meta', true);


    // Output HTML for meta box
    ?>
    <label class="screen-reader-text" for="custom_course_tip_meta">Bundle Course Tip</label>
    <textarea rows="1" cols="40" name="custom_course_tip_meta"
        id="custom_course_tip_meta"><?php echo esc_html($bundle_course_tip); ?> </textarea>
    <?php
}
function featured_details($post)
{
    // Retrieve existing meta values
    $featured_details = get_post_meta($post->ID, 'featured_meta', true);


    // Output HTML for meta box
    ?>
    <label class="screen-reader-text" for="featured_meta">Featured Tip</label>
    <textarea rows="1" cols="40" name="featured_meta" id="featured_meta"><?php echo esc_html($featured_details); ?> </textarea>
    <?php
}

// Save custom meta data when the post is updated
function save_custom_details_meta($post_id)
{

    // Check if auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save meta data
    if (isset($_POST['custom_course_tip_meta'])) {
        update_post_meta($post_id, 'custom_course_tip_meta', sanitize_text_field($_POST['custom_course_tip_meta']));
    }
    // Save meta data
    if (isset($_POST['featured_meta'])) {
        update_post_meta($post_id, 'featured_meta', sanitize_text_field($_POST['featured_meta']));
    }
}
add_action('save_post', 'save_custom_details_meta');