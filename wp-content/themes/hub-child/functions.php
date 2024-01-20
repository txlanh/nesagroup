<?php

function enqueue_custom_script() {
    // Ðang ký và enqueue script
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
}

// Hook vào action wp_enqueue_scripts
add_action('wp_enqueue_scripts', 'enqueue_custom_script');


add_action( 'wp_enqueue_scripts', 'liquid_child_theme_style', 99 );

function liquid_parent_theme_scripts() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
function liquid_child_theme_style(){
    wp_enqueue_style( 'child-hub-style', get_stylesheet_directory_uri() . '/style.css' );	
}