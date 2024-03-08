<?php
function a2n_assets()
{
    // Enqueue top-course stylesheet
    wp_enqueue_style("top-course", get_stylesheet_directory_uri() . "/assets/css/top_course.css", null, time());

    // Enqueue career-bundle stylesheet
    wp_enqueue_style("career-bundle", get_stylesheet_directory_uri() . "/assets/css/career_bundle.css", null, time());

    // mouse helper css 
    wp_enqueue_style("mouse-helper", get_stylesheet_directory_uri() . "/assets/css/mouse_helper.css", null, time());

    // mouse helper js 
    wp_enqueue_script("mouse-helper", get_stylesheet_directory_uri() . "/assets/js/app.js", array('jquery'), time(), true);
}
add_action('wp_enqueue_scripts', 'a2n_assets');



// include all functions 
include_once get_stylesheet_directory() . '/inc/top-course_function.php';
include_once get_stylesheet_directory() . '/inc/bundle-course_function.php';