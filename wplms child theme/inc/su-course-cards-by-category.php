<?php
function su_cards_cate_shortcode($atts)
{

    $atts = shortcode_atts(
        array(
            'category' => '',
        ),
        $atts
    );
    ob_start();

    $category_slug = $atts['category'];
    if (!empty($category_slug)) {
        $category = get_term_by('slug', $category_slug, 'course-cat');
        $category_name = $category->name;
        $category_description = $category->description;
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => 4,
            "post_status" => "published",
            "tax_query" => array(
                array(
                    'taxonomy' => 'course-cat',
                    'field' => 'slug',
                    'terms' => $category_slug,
                ),
            ),
        );
    }

    $loop = new WP_Query($arg);
    ?>
    <div class="r4h-su-category-tab-courses">
        <?php
        if (!empty($category_name)) {
            echo '<h2 class="su-category-name">Expand Your Career Opportunities with ' . $category_name . '</h2>';
        }
        if (!empty($category_description)) {
            echo '<p  class="su-category-description">' . $category_description . '</p>';
        }
        ?>

        <div class="cat-courses-button">
            <a href="/course-cat/<?php echo $category_slug ?>">Explore <?php echo $category_name ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                    <path
                        d="M11.9867 0.281372C5.91153 0.281372 0.986664 5.20624 0.986664 11.2814C0.986664 17.3565 5.91153 22.2814 11.9867 22.2814C18.0618 22.2814 22.9867 17.3565 22.9867 11.2814C22.9867 5.20624 18.0618 0.281372 11.9867 0.281372Z"
                        fill="white" />
                    <path d="M10.4143 13.9009L13.5571 11.2819L10.4143 8.66284" stroke="#7B87F4" stroke-width="1.16236"
                        stroke-linejoin="round" />
                </svg>
            </a>
        </div>
        <?php

        if ($loop->have_posts()) {
            ?>
            <div class="r4h-su-category-tab-courses_container">
                <?php
                while ($loop->have_posts()) {
                    $loop->the_post();

                    $course_ID = get_the_ID();
                    $course_title = get_the_title($course_ID);
                    $course_img = get_the_post_thumbnail_url($course_ID, "large");
                    $bundle_tip = get_post_meta($course_ID, 'custom_course_tip_meta', true);
                    $course_link = get_the_permalink($course_ID);
                    $average_rating = get_post_meta($course_ID, 'average_rating', true);
                    $reviewsUsers = get_post_meta($course_ID, 'rating_count', true);
                    $featured_meta = get_post_meta($course_ID, 'featured_meta', true);
                    $course_students = get_post_meta($course_ID, 'vibe_students', true);
                    $course_levels = get_the_terms($course_ID, 'level', true);

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
                    ?>
                    <div class="r-su-home-4-course_card_h">
                        <div class="image-duration-featured">
                            <?php
                            if ($featured_meta) {
                                ?>
                                <p class="featured">
                                    <span> &#9733; </span>
                                    <span> <?php echo $featured_meta ?> </span>
                                </p>
                            <?php } ?>

                            <div class="course-thumb-image">
                                <img src="<?php echo $course_img ?>" alt="" />
                            </div>
                            <?php
                            if ($featured_meta) {
                                ?>
                                <p class="featured">
                                    <span> &#9733; </span>
                                    <span> <?php echo $featured_meta ?> </span>
                                </p>
                            <?php } ?>
                            <!-- <p class="duration">
                                <span> &#128339; </span>
                                <span> 01 year </span>
                            </p> -->
                        </div>
                        <div class="course-meta-data">
                            <h4 class="course-title">
                                <a href="<?php echo $course_link ?>">
                                    <?php echo $course_title ?>
                                </a>
                            </h4>
                            <div class="a2n-course_meta">
                                <div class="meta-detail">
                                    <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.38511 0.210799C3.78849 0.162224 0.852285 3.09828 0.900863 6.69473C0.948826 10.1439 3.75743 12.9524 7.20678 13.0003C10.804 13.0495 13.7396 10.1135 13.6904 6.51703C13.6431 3.06723 10.8345 0.25876 7.38511 0.210799ZM7.27196 4.88728C7.27842 4.85039 7.28549 4.8135 7.29379 4.77691C7.37145 4.41787 7.54447 4.0864 7.79464 3.81739C8.19095 3.39527 8.75267 3.16223 9.3765 3.16223C9.63895 3.16115 9.89962 3.20546 10.147 3.2932C10.4545 3.40268 10.7314 3.58397 10.9547 3.822C11.2832 4.17703 11.4787 4.63478 11.5081 5.11756C11.5166 5.23423 11.5166 5.35137 11.5081 5.46804C11.4844 5.7987 11.3989 6.12198 11.256 6.42111C11.2404 6.4537 11.2241 6.48598 11.2071 6.51795C11.173 6.58159 11.1364 6.644 11.097 6.70426C11.0187 6.82456 10.9299 6.93773 10.8317 7.04245C10.4283 7.47286 9.91178 7.71052 9.37711 7.71052C9.17662 7.71038 8.97751 7.67735 8.78772 7.61275C8.72395 7.5911 8.66136 7.56616 8.60017 7.53804C8.34393 7.41851 8.11344 7.25017 7.92162 7.04245C7.52232 6.60936 7.28358 6.05247 7.24521 5.46466C7.23968 5.38513 7.23783 5.30643 7.23968 5.22854C7.24206 5.11436 7.25285 5.0005 7.27196 4.8879V4.88728ZM2.66843 5.6356C2.68339 5.41623 2.73754 5.20131 2.8283 5.00104C2.85391 4.94526 2.88244 4.89087 2.91378 4.83809C2.97645 4.73231 3.05059 4.63374 3.13484 4.54418C3.25965 4.41104 3.40496 4.29874 3.56527 4.21153C3.64534 4.16777 3.72871 4.13036 3.81462 4.09962C4.14381 3.98449 4.49774 3.95913 4.83999 4.02614C5.20263 4.09628 5.53385 4.2792 5.78633 4.54879C6.08594 4.87219 6.25478 5.29532 6.26012 5.73613C6.26166 5.801 6.26012 5.86618 6.25551 5.93228C6.23675 6.1854 6.17434 6.43337 6.07104 6.66522C6.02158 6.77684 5.96264 6.88401 5.89487 6.98557C5.76453 7.18252 5.6005 7.35497 5.41032 7.495C5.3642 7.52789 5.31624 7.55864 5.26674 7.58938C5.16938 7.64736 5.06636 7.69527 4.95928 7.73234C4.79917 7.78829 4.6308 7.81697 4.4612 7.8172C4.43261 7.8172 4.40401 7.8172 4.37573 7.81474C4.31924 7.81165 4.26299 7.80528 4.20724 7.79568C4.15178 7.78602 4.09687 7.7734 4.04275 7.75786C3.96147 7.73439 3.88212 7.70468 3.8054 7.66901C3.77957 7.65702 3.75436 7.64441 3.72915 7.6312C3.17573 7.33943 2.75851 6.7347 2.67673 6.02881C2.67304 5.99653 2.66996 5.96425 2.66781 5.93166C2.66087 5.83309 2.66108 5.73414 2.66843 5.6356ZM4.32623 11.1265C3.50761 10.5869 2.84971 9.83655 2.42185 8.95442C2.40787 8.92621 2.40525 8.89372 2.41451 8.86364C2.42378 8.83355 2.44423 8.80817 2.47165 8.79271C3.04291 8.47143 3.7725 8.2965 4.46182 8.2965C4.98449 8.2965 5.4057 8.35799 5.77434 8.47727C5.81614 8.49103 5.85348 8.51574 5.88247 8.54883C5.91146 8.58193 5.93104 8.6222 5.93917 8.66543C5.94731 8.70867 5.94369 8.7533 5.92871 8.79467C5.91372 8.83603 5.88792 8.87262 5.85398 8.90062C5.13607 9.48476 4.67335 10.2085 4.45597 11.0758C4.45272 11.089 4.44633 11.1013 4.43733 11.1116C4.42833 11.1219 4.41699 11.1298 4.40427 11.1348C4.39155 11.1398 4.37782 11.1416 4.36423 11.1402C4.35065 11.1387 4.33762 11.134 4.32623 11.1265ZM7.29594 12.0165C6.60374 12.0172 5.91789 11.8845 5.27596 11.6255C5.24973 11.6146 5.22805 11.5951 5.2146 11.5701C5.20115 11.5451 5.19676 11.5162 5.20217 11.4883C5.21447 11.4253 5.228 11.3678 5.23999 11.3199C5.45889 10.4458 6.00125 9.72118 6.80801 9.22374C7.52408 8.78256 8.43753 8.53968 9.37588 8.53968C10.3339 8.53968 11.2206 8.77272 11.9425 9.21329C11.9609 9.22479 11.9741 9.24299 11.9793 9.26404C11.9845 9.2851 11.9814 9.30735 11.9705 9.32612C11.4944 10.144 10.8123 10.8227 9.99209 11.2948C9.1719 11.7669 8.24229 12.0157 7.29594 12.0165Z"
                                            fill="#2B354E" />
                                    </svg>

                                    <p><?php echo $course_students ?> Students</p>

                                </div>
                                <div class="meta-detail">
                                    <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.868 9.83071L9.32189 12.0251L8.40533 7.88933L11.4568 5.10668L7.43846 4.74782L5.868 0.847412L4.29754 4.74782L0.279175 5.10668L3.33067 7.88933L2.41411 12.0251L5.868 9.83071Z"
                                            fill="#FCBF02" />
                                    </svg>

                                    <div class="a2n-ratings-container">
                                        <p><?php echo $average_rating ?> <span class="total-reviews">(<?php
                                            if ($reviewsUsers) {
                                                echo $reviewsUsers;
                                            } else {
                                                echo '0';
                                            }
                                            ?>)</span></p>

                                    </div>

                                </div>

                            </div>
                            <div class="a2n-course_meta">
                                <div class="meta-detail">
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.66186 8.10606H4.79493C4.98205 8.10606 5.13465 8.25866 5.13465 8.44578V14.4116C5.13465 14.5987 4.98205 14.7513 4.79493 14.7513H2.66186C2.47474 14.7513 2.32214 14.5987 2.32214 14.4116V8.44578C2.32214 8.25866 2.47474 8.10606 2.66186 8.10606ZM7.29568 4.74981H9.42876C9.61587 4.74981 9.76847 4.90241 9.76847 5.08952V14.4116C9.76847 14.5987 9.61587 14.7513 9.42876 14.7513C8.71773 14.7513 8.00671 14.7513 7.29568 14.7513C7.10857 14.7513 6.95597 14.5987 6.95597 14.4116C6.95597 11.3042 6.95597 8.19687 6.95597 5.08952C6.956 4.90241 7.1086 4.74981 7.29568 4.74981ZM11.9295 1.39355H14.0626C14.2497 1.39355 14.4023 1.54616 14.4023 1.73327V14.4116C14.4023 14.5987 14.2497 14.7513 14.0626 14.7513C13.3516 14.7513 12.6405 14.7513 11.9295 14.7513C11.7424 14.7513 11.5898 14.5987 11.5898 14.4116C11.5898 10.1855 11.5898 5.95937 11.5898 1.73327C11.5898 1.54616 11.7424 1.39355 11.9295 1.39355Z"
                                            fill="#7481EF" />
                                    </svg>

                                    <p>
                                        <?php
                                        foreach ($course_levels as $level) {
                                            echo $level->name;
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="meta-detail">
                                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_2694_1338" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                            width="12" height="11">
                                            <rect x="0.728394" y="0.212769" width="10.6638" height="10.6638" fill="#7481EF" />
                                        </mask>
                                        <g mask="url(#mask0_2694_1338)">
                                            <path
                                                d="M7.85279 8.00455L8.54557 7.31177L6.71464 5.48085V3.20457H5.72496V5.87672L7.85279 8.00455ZM6.2198 10.6272C5.53527 10.6272 4.89197 10.4972 4.28991 10.2373C3.68785 9.97766 3.16414 9.62517 2.71878 9.17981C2.27342 8.73445 1.92093 8.21074 1.6613 7.60868C1.40134 7.00662 1.27136 6.36332 1.27136 5.67879C1.27136 4.99425 1.40134 4.35095 1.6613 3.74889C1.92093 3.14683 2.27342 2.62312 2.71878 2.17777C3.16414 1.73241 3.68785 1.37975 4.28991 1.11979C4.89197 0.860161 5.53527 0.730347 6.2198 0.730347C6.90434 0.730347 7.54763 0.860161 8.14969 1.11979C8.75175 1.37975 9.27546 1.73241 9.72082 2.17777C10.1662 2.62312 10.5187 3.14683 10.7783 3.74889C11.0383 4.35095 11.1682 4.99425 11.1682 5.67879C11.1682 6.36332 11.0383 7.00662 10.7783 7.60868C10.5187 8.21074 10.1662 8.73445 9.72082 9.17981C9.27546 9.62517 8.75175 9.97766 8.14969 10.2373C7.54763 10.4972 6.90434 10.6272 6.2198 10.6272ZM6.2198 9.63754C7.3167 9.63754 8.25081 9.25205 9.0221 8.48109C9.79307 7.70979 10.1786 6.77569 10.1786 5.67879C10.1786 4.58188 9.79307 3.64778 9.0221 2.87648C8.25081 2.10552 7.3167 1.72003 6.2198 1.72003C5.1229 1.72003 4.18896 2.10552 3.41799 2.87648C2.6467 3.64778 2.26105 4.58188 2.26105 5.67879C2.26105 6.77569 2.6467 7.70979 3.41799 8.48109C4.18896 9.25205 5.1229 9.63754 6.2198 9.63754Z"
                                                fill="#7481EF" />
                                        </g>
                                    </svg>

                                    <p>
                                        <?php
                                        if (!function_exists('convert_seconds_to_readable_time')) {
                                            function convert_seconds_to_readable_time($seconds)
                                            {
                                                if ($seconds >= 3600) {
                                                    $hours = floor($seconds / 3600);
                                                    return $hours . ' hours';
                                                } else {
                                                    $minutes = floor($seconds / 60);
                                                    return $minutes . ' minutes';
                                                }
                                            }
                                        }
                                        $courseDuration = convert_seconds_to_readable_time($total_duration);
                                        echo $courseDuration;
                                        ?>
                                    </p>


                                </div>
                            </div>
                        </div>

                        <div class="price-button">
                            <a href="<?php echo $course_link ?>" class="course_details_button">View Course</a>
                            <div class="course-price-details">
                                <?php
                                bp_course_credits();
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        wp_reset_query();
        } else {
            echo "No Course Found";
        }
        return ob_get_clean();
}

add_shortcode('su_cards_cate', 'su_cards_cate_shortcode');
?>