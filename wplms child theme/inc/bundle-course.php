<?php

// course shortcode function 

function a2n_bundle_courses_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'id' => '',
        ),
        $atts
    );
    ob_start();

    $a2n_course_id = $atts['id'];
    if (!empty($a2n_course_id)) {
        $a2n_course_ids = $a2n_course_id;
        $a2n_course_ids = (explode(",", $a2n_course_ids));
        $course_id = array();
        if ($a2n_course_ids) {
            foreach ($a2n_course_ids as $a2n_course_id) {
                $course_id[] = $a2n_course_id;
            }
        }
        $args = array(
            'post_type' => 'course',
            'posts_per_page' => 4,
            'post__in' => $course_id,
            'post_status' => 'published',
        );
    }
    $fetch = new WP_Query($args);
    if ($fetch->have_posts()) {
        while ($fetch->have_posts()) {
            $fetch->the_post();

            $course_ID = get_the_ID();
            $course_title = get_the_title($course_ID);
            $course_img = get_the_post_thumbnail_url($course_ID, "large");
            $average_rating = get_post_meta($course_ID, 'average_rating', true);
            $count_rating = get_post_meta($course_ID, 'rating_count', true);
            $units = bp_course_get_curriculum_units($course_ID);
            $durations = $total_durations = 0;

            foreach ($units as $unit) {
                $durations = get_post_meta($units, 'vibe_durations', true);
                if (empty($durations)) {
                    $durations = 0;
                }
                if (get_post_type($unit) == 'unit') {
                    $unit_durations_parameter = apply_filters('vibe_unit_duration_parameter', 60, $unit);
                } elseif (get_post_type($unit) == 'quize') {
                    $unit_durations_parameter = apply_filters('vibe_unit_duration_parameter', 60, $unit);
                }
                $total_durations = $total_durations + $durations * $unit_durations_parameter;
            }

            // $course_durations = tofriendlytime(($total_duration));
            $course_students = get_post_meta($course_ID, 'vibe_students', true);
            $course_link = get_the_permalink($course_ID);
            $taxonomy = 'course-cat';
            // $terms = wp_get_post_terms(
            //     $course_id,
            //     $texonomy,
            //     array(
            //         'fields' => 'all'
            //     )
            // );
            ?>

            <div class="a2n-career_bundle">
                <div class="a2n-bundle_img">
                    <img src="./assets/images/Rectangle 6308.png" alt="" />
                    <div class="a2n_tip">
                        <h3>7 in 1 Bundle</h3>
                    </div>
                </div>
                <div class="a2n-bundle__contents">
                    <div class="bundle_title">
                        <a href="#">Anti-money Laundering Specialist Training</a>
                    </div>
                    <ul class="a2n-bundle_details">
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/Group.svg" alt="check" />15
                            Courses Bundle
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/Group.svg" alt="check" />Free Pdf
                            Certificate
                        </li>
                        <li>
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/Group.svg" alt="check" />Unlimited Free
                            Retake Exam
                        </li>
                    </ul>
                </div>
                <div class="a2n-bundle__footer">
                    <div class="course_price">
                        <div class="price">
                            <span class="ammout">£17.00</span>
                            <del>£219.00</del>
                        </div>
                    </div>
                    <div class="bundle_btn">
                        <a href="#">Add to Cart</a>
                    </div>
                </div>
            </div>






            <?php
        }
        wp_reset_query();
    } else {
        echo "no course found";
    }
    return ob_get_clean();
}
add_shortcode('a2n_bundle_courses', 'a2n_bundle_courses_shortcode');