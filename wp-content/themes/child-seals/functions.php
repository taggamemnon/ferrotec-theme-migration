<?php
/**
 * ferrotec functions and definitions
 *
 * @package seals
 */

function seals_enqueue_styles() {

    $parent_style = 'layers-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'thermal-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'seals_enqueue_styles' );


