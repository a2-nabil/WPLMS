<?php

if (!defined('ABSPATH'))
    exit;

$header = vibe_get_customizer('header_style');
if ($header == 'transparent' || $header == 'generic') {
    echo '<section id="title">';
    do_action('wplms_before_title');
    echo '<div class="container"><div class="pagetitle"><h1>' . get_the_title() . '</h1></div></div></section>';
}
?>
<section id="">
    <div id="">
        <!-- course hero area start  -->
        <div class="a2n-hero_area a2n-section_area">
            <div class="a2n-area_container">
                <div class="hero_contents">
                    <h2 class="course-title"><?php the_title(); ?></h2>
                    <h6 class="course-desc">
                        <?php echo get_the_excerpt(); ?>
                    </h6>
                    <div class="course-info">
                        <i class="fa fa-user-circle"></i>
                        <?php
                        $students = get_post_meta(get_the_ID(), 'vibe_students', true);

                        echo '<span>' . $students . __(' students enrolled', 'vibe') . '</span>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- course hero area end  -->
        <!-- course tabs area start  -->
        <div class="a2n-tabs_area">
            <div class="a2n-area_container">
                <div class="a2n-tabs_area__container">
                    <!-- all tabs start here  -->
                    <main class="a2n_tabs_container">
                        <!-- course tabs nav start  -->
                        <div class="a2n-course_nav">
                            <ul class="a2n_nav-list">
                                <li>
                                    <a class="a2n_active" href="#a2n_description"> Description</a>
                                </li>
                                <li>
                                    <a href="#a2n_curriculum"> Curriculum</a>
                                </li>
                                <li>
                                    <a href="#a2n_reviews"> Reviews</a>
                                </li>
                            </ul>
                        </div>
                        <!-- course tabs nav end  -->

                        <?php
                        do_action('wplms_before_course_description');
                        ?>
                        <!-- Description tab start  -->
                        <div id="a2n_description" class="a2n_course_tabs a2n_active_tab">
                            <?php echo get_the_content(); ?>
                        </div>
                        <!-- Description tab end  -->

                        <!-- Curriculum tab start  -->
                        <div id="a2n_curriculum" class="a2n_course_tabs">
                            <?php
                            do_action('wplms_after_course_description');
                            ?>
                        </div>
                        <!-- Curriculum tab end  -->
                        <!-- Reviews tab start  -->
                        <div id="a2n_reviews" class="a2n_course_tabs">
                            <?php
                            if (!is_user_logged_in()) {
                                echo '<h4>Be the first to add a review.</h4> 
                                <div id="a2n_add_review">
                                Please,
                                <a href="#">login</a> to leave a review
                                </div>';

                            } else {
                                comments_template('/course-review.php', true);
                            }
                            ?>
                        </div>
                        <!-- Reviews tab end  -->
                        <!-- Related Course area Start -->
                        <div class="a2n-related_area">
                            <h2 class="a2n_title">Related Courses</h2>
                            <div class="a2n-related_courses__container">
                                <!--#1 Related Course Card start  -->
                                <div class="a2n-course_card">
                                    <div class="a2n-course_start">
                                        <div class="a2n-course_thumb">
                                            <a href="#">
                                                <img src="./assets/images/Dementia-Nurse-1-1536x1025-1.webp" alt="" />
                                            </a>
                                        </div>
                                        <a href="#">
                                            <span class="a2n-course__price">
                                                <!-- price replace start  -->
                                                <strong><del aria-hidden="true"><span
                                                            class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">£</span>1099</bdi></span></del>
                                                    <ins><span class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">£</span>199</bdi></span></ins>
                                                    <small class="woocommerce-price-suffix">ex Vat</small></strong>
                                                <!-- price replace end  -->
                                            </span>
                                        </a>
                                    </div>
                                    <div class="a2n-course__contents">
                                        <h2 class="course_title">
                                            <a href="#">Dementia Nurse (Diploma)</a>
                                        </h2>
                                        <div class="a2n-course__terms">
                                            <span> Health & Social Care</span>
                                        </div>
                                        <div class="a2n-course__end">
                                            <div class="a2n-meta">
                                                <i class="fas fa-signal"></i>
                                                <span>Intermediate</span>
                                            </div>
                                            <div class="a2n-meta">
                                                <i class="fas fa-list"></i>
                                                <span>13 Lectures</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--#1 Related Course Card end  -->
                                <!--#2 Related Course Card start  -->
                                <div class="a2n-course_card">
                                    <div class="a2n-course_start">
                                        <div class="a2n-course_thumb">
                                            <a href="#">
                                                <img src="./assets/images/Dementia-Nurse-1-1536x1025-1.webp" alt="" />
                                            </a>
                                        </div>
                                        <a href="#" class="stm_price_course_hoverable">
                                            <span class="a2n-course__price">
                                                <!-- price replace start  -->
                                                <strong><del aria-hidden="true"><span
                                                            class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">£</span>424.99</bdi></span></del>
                                                    <ins><span class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">£</span>25.00</bdi></span></ins>
                                                    <small class="woocommerce-price-suffix">ex Vat</small></strong>
                                                <!-- price replace end  -->
                                            </span>
                                        </a>
                                    </div>
                                    <div class="a2n-course__contents">
                                        <h2 class="course_title">
                                            <a href="#">Dementia Nurse (Diploma)</a>
                                        </h2>
                                        <div class="a2n-course__terms">
                                            <span> Health & Social Care</span>
                                        </div>
                                        <div class="a2n-course__end">
                                            <div class="a2n-meta">
                                                <i class="fas fa-signal"></i>
                                                <span>Intermediate</span>
                                            </div>
                                            <div class="a2n-meta">
                                                <i class="fas fa-list"></i>
                                                <span>13 Lectures</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--#2 Related Course Card end  -->
                                <!--#3 Related Course Card start  -->
                                <div class="a2n-course_card">
                                    <div class="a2n-course_start">
                                        <div class="a2n-course_thumb">
                                            <a href="#">
                                                <img src="./assets/images/Dementia-Nurse-1-1536x1025-1.webp" alt="" />
                                            </a>
                                        </div>
                                        <a href="#" class="stm_price_course_hoverable">
                                            <span class="a2n-course__price">
                                                <!-- price replace start  -->
                                                <strong><del aria-hidden="true"><span
                                                            class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">£</span>424.99</bdi></span></del>
                                                    <ins><span class="woocommerce-Price-amount amount"><bdi><span
                                                                    class="woocommerce-Price-currencySymbol">£</span>25.00</bdi></span></ins>
                                                    <small class="woocommerce-price-suffix">ex Vat</small></strong>
                                                <!-- price replace end  -->
                                            </span>
                                        </a>
                                    </div>
                                    <div class="a2n-course__contents">
                                        <h2 class="course_title">
                                            <a href="#">Certificate In Public Health & Epidemiology</a>
                                        </h2>
                                        <div class="a2n-course__terms">
                                            <span> Health & Social Care</span>
                                        </div>
                                        <div class="a2n-course__end">
                                            <div class="a2n-meta">
                                                <i class="fas fa-signal"></i>
                                                <span>Intermediate</span>
                                            </div>
                                            <div class="a2n-meta">
                                                <i class="fas fa-list"></i>
                                                <span>13 Lectures</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--#3 Related Course Card end  -->
                            </div>
                        </div>
                        <!-- Related Course area End -->
                    </main>
                    <!-- all tabs end  -->
                    <!-- sidebar area start  -->
                    <aside class="a2n-course_sidebar">
                        <div class="a2n-course_thumb">
                            <?php echo get_the_post_thumbnail(); ?>
                        </div>
                        <div class="a2n-exp_notice">
                            <i class="far fa-clock"></i>
                            <h6>Course available for <strong>365 days</strong></h6>
                        </div>
                        <div class="a2n_course-btn">
                            <?php the_course_button(); ?>
                            <?php bp_course_credits(); ?>
                        </div>
                        <div class="a2n-course_includes">
                            <h4>Includes</h4>
                            <?php  ?>
                            <ul>
                                <li><i class="fas fa-book"></i> 11 lectures</li>
                                <li><i class="far fa-clock"></i> 1 year</li>
                                <li>
                                    <i class="fas fa-certificate"></i> CPD-accredited Digital
                                    Certificate
                                </li>
                            </ul>
                        </div>
                    </aside>
                    <!-- sidebar area end  -->
                </div>
            </div>
        </div>
        <!-- course tabs area end  -->