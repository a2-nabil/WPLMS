<?php

// course shortcode function 

function a2n_course_by_id($atts, $limit)
{
    ?>

    <?php
    ob_start();

    $category_id = $atts['cat_id'];
    $course_ids = $atts['course_ids'];
    $limit = $atts['limit'];

    $new_array_numbers = array_map('intval', explode(',', $course_ids));

    if ($category_id) {
        $args = array(
            'post_type' => 'course',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'course-cat',
                    'field' => 'term_id',
                    'terms' => $category_id
                )
            ),
            'meta_query' => array(
                array(
                    'key' => 'vibe_students',
                ),
                array(
                    'key' => 'vibe_product',
                    'value' => array(''),
                    'compare' => 'NOT IN'
                )
            )
        );
    } elseif ($course_ids) {
        $args = array(
            'post_type' => 'course',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'post__in' => $new_array_numbers,
            'orderby' => 'post__in',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'vibe_students',
                ),
                array(
                    'key' => 'vibe_product',
                    'value' => array(''),
                    'compare' => 'NOT IN'
                )
            )
        );
    } else {
        $args = array(
            'post_type' => 'course',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'vibe_students',
                ),
                array(
                    'key' => 'vibe_product',
                    'value' => array(''),
                    'compare' => 'NOT IN'
                )
            )
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="a2n-pCourse_wrapper">';
        while ($query->have_posts()):
            $query->the_post();
            $course_ID = get_the_ID();
            $units = bp_course_get_curriculum_units($course_ID);

            $duration = $total_duration = 0;

            foreach ($units as $unit) {
                $duration = get_post_meta($unit, 'vibe_duration', true);
                if (empty($duration)) {
                    $duration = 0;
                }
                if (get_post_type($unit) == 'unit') {
                    $unit_duration_parameter = apply_filters('vibe_unit_duration_parameter', 60, $unit);
                } elseif (get_post_type($unit) == 'quiz') {
                    $unit_duration_parameter = apply_filters('vibe_quiz_duration_parameter', 60, $unit);
                }
                $total_duration = $total_duration + $duration * $unit_duration_parameter;
            }

            if (!function_exists('convert_seconds_to_hours_minutes')) {
                function convert_seconds_to_hours_minutes($seconds)
                {
                    $hours = floor($seconds / 3600);
                    $minutes = floor(($seconds % 3600) / 60);
                    return sprintf('%02dh %02dm', $hours, $minutes);
                }
            }
            $courseDuration = convert_seconds_to_hours_minutes($total_duration);

            ?>



            <div class="a2n-popular_course">
                <div class="popular_thumb">
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail();
                        } else {
                            echo '<img src="https://dummyimage.com/600x400/7d797d/ffffff" alt="alt image" />';
                        }
                        ?>
                    </a>
                </div>
                <div class="a2n-popular__contents">
                    <div class="popular_title">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div>
                    <div class="a2n-course_meta">
                        <div class="module_count course_meta">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/book-1.svg" alt="" />
                            Modules <?php echo count($units); ?>
                        </div>
                        <div class="durations_count course_meta">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clock-circle-1.svg" alt="" />
                            <?php echo $courseDuration; ?>
                        </div>
                    </div>
                    <div class="a2n-course__end"><a class="a2n_popular_btn" href="<?php the_permalink(); ?>">View Course</a></div>
                </div>
            </div>

            <?php
        endwhile;
        echo '</div>';
        wp_reset_query();
    } else {
        echo "<h3>No course found</h3>";
    }
    return ob_get_clean();
}
add_shortcode('a2n_course_by_id', 'a2n_course_by_id');