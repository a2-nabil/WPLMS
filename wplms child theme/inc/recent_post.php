<?php 
function display_recent_posts($atts) {
    // Attributes
    $atts = shortcode_atts(
        array(
            'category' => '', 
            'limit' => 3,
        ),
        $atts,
        'recent_posts'
    );
    ob_start();

    // Custom query parameters
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $atts['limit'],
        'post_status' => 'publish',
    );

    // If category is provided, add it to the query parameters
    if (!empty($atts['category'])) {
        $args['category_name'] = $atts['category'];
    }

    $recent_posts_query = new WP_Query($args);

    if ($recent_posts_query->have_posts()) {

        while ($recent_posts_query->have_posts()) {
            $recent_posts_query->the_post();
            
            ?> 
            <!-- Card start  -->
            <div class="r-su-home-4-blog-card-h">
                <div class="blog_image">
                    <img decoding="async" src="<?php the_post_thumbnail('large'); ?>" alt="">
                </div>
                <div class="blog-data">
                    <div class="blog_title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </div>
                    <div class="blog_exerpt">
                        <p>
                            <?php echo the_excerpt(); ?>
                        </p>
                    </div>
                </div>
                <div class="blog_button">
                    <a href="<?php the_permalink(); ?>">
                        <i aria-hidden="true" class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <!-- Card end  -->
            <?php
        }
        wp_reset_postdata();
    } else {
        echo "No posts found.";
    }

    return ob_get_clean();
}
add_shortcode('recent_posts', 'display_recent_posts');
?>