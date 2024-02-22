<?php
// bundle course shortcode function 
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
            'posts_per_page' => 3,
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
            // add custom meta 
            $meta_key = 'bundle_course_details';
            $meta_value = 'Courses Bundle / Free Pdf Certificate / Unlimited Free Retake Exam';
            $meta_key_tip = 'bundle_tip';
            $meta_value_tip = '7 in 1 Bundle';
            if ($course_ID && get_post_type($course_ID) === 'course') {
                add_post_meta($course_ID, $meta_key, $meta_value, true);
                add_post_meta($course_ID, $meta_key_tip, $meta_value_tip, true);
            }
            $bundle_course_details = get_post_meta($course_ID, 'bundle_course_details', true);
            $bundle_tip = get_post_meta($course_ID, 'bundle_tip', true);
            $course_link = get_the_permalink($course_ID);
            $product_ID = get_post_meta($course_ID, 'vibe_product', true);
            $add_to_cart_url = wc_get_cart_url() . '?add-to-cart=' . $product_ID;

            ?>

            <div class="a2n-career_bundle">
                <div class="a2n-bundle_img">
                    <img src="<?php echo $course_img ?>" alt="" />
                    <div class="a2n_tip">
                        <h3>
                            <?php echo $bundle_tip ?>
                        </h3>
                    </div>
                </div>
                <div class="a2n-bundle__contents">
                    <div class="bundle_title">
                        <a href="<?php
                        echo esc_attr($course_link);
                        ?>">
                            <?php
                            echo esc_html($course_title);
                            ?>
                        </a>
                    </div>
                    <ul class="a2n-bundle_details">
                        <?php
                        if ($bundle_course_details) {
                            $details_array = explode('/', $bundle_course_details);
                            foreach ($details_array as $detail) {
                                ?>
                                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Group.svg" alt="check" />
                                    <?php echo trim($detail); ?>
                                </li>
                                <?php

                            }
                        }
                        ?>



                    </ul>
                </div>
                <div class="a2n-bundle__footer">
                    <div class="course_price">
                        <div class="price">
                            <?php
                            bp_course_credits();
                            ?>
                        </div>
                    </div>
                    <div class="bundle_btn">
                        <a class="a2n-cart_btn" href="
                        <?php
                        echo $add_to_cart_url ?>
                        ">Add to Cart</a>

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