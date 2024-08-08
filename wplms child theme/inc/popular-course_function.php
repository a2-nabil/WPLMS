<?php

// course shortcode function 

function a2n_courses_shortcode($atts)
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
            $average_rating = get_post_meta($course_ID, 'average_rating', true);
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
            $course_students = get_post_meta($course_ID, 'vibe_students', true);
            $course_link = get_the_permalink($course_ID);
            $product_ID = get_post_meta($course_ID, 'vibe_product', true);
            $featured_meta = get_post_meta($course_ID, 'featured_meta', true);


            ?>
            <div class="a2n_popular-course">
                <div class="a2n_course-thumb">
                    <a href="<?php echo $course_link ?>">
                        <img src="<?php echo $course_img ?>" alt="courseImage" /></a>
                    <?php
                    $featured_class = strtolower(str_replace(' ', '', $featured_meta));
                    if ($featured_meta) {
                        echo '<div class="a2n_course-cat ' . $featured_class . ' "><h6>
                            ' . $featured_meta . '
                            </h6></div>';
                    }
                    ?>
                </div>
                <?php
                $product = wc_get_product($product_ID);

                // Check if the product exists
                if ($product) {
                    $sale_price = $product->get_sale_price();
                    $regular_price = $product->get_regular_price();

                    // Check if both sale price and regular price are numeric
                    if (is_numeric($sale_price) && is_numeric($regular_price) && $regular_price != 0) {
                        // Calculate the discount percentage
                        $discount = ($regular_price - $sale_price) / $regular_price * 100;


                        if ($discount != 0) {
                            ?>
                            <div class="a2n_sale-box">Winter Sale <?php echo round($discount); ?>% OFF</div>
                            <?php
                        }


                    } else {
                        ?>
                        <div class="a2n_sale-box"></div>
                        <?php
                    }
                } else {
                    // Handle if product is not found
                    echo "Product not found";
                }
                ?>

                <div class="a2n-course_contents">
                    <div class="a2n-course_title">
                        <h2>
                            <a href="<?php echo $course_link ?>">
                                <?php echo $course_title ?>
                            </a>
                        </h2>
                    </div>
                    <div class="a2n_course-meta">
                        <?php
                        if (is_numeric($average_rating)) {
                            $percentage = ($average_rating / 5) * 100;
                        }
                        ?>
                        <div class="a2n-ratings-container bp_blank_stars">
                            <div style="width:<?php echo $percentage ?>%" class="bp_filled_stars"></div>
                        </div>
                        <div class="a2n-course__count-student">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Vector (14).svg" alt="" />
                            <span><?php echo $course_students ?> Students</span>
                        </div>
                    </div>
                    <div class="a2n_course-meta a2n_course-end">
                        <div class="view_course">
                            <a href="<?php
                            echo $course_link
                                ?>"> View course </a>
                        </div>
                        <div class="a2n-course_price">
                            <?php
                            bp_course_credits();
                            ?>
                        </div>
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
add_shortcode('popular_courses', 'a2n_courses_shortcode');