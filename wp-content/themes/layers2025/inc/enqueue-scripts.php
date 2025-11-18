<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package Layers2025
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue theme styles
 */
function layers2025_enqueue_styles() {
    // Bootstrap 5 from CDN
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    // Ferrotec Custom Styles - Consolidated CSS (all custom styles from old themes)
    // Use minified version in production for better performance
    $ferrotec_css = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
        ? 'ferrotec-custom.css'
        : 'ferrotec-custom.min.css';

    wp_enqueue_style(
        'ferrotec-custom',
        LAYERS2025_URI . '/assets/css/' . $ferrotec_css,
        array( 'bootstrap' ),
        LAYERS2025_VERSION
    );

    // Main theme stylesheet (WordPress requirement, loaded last)
    wp_enqueue_style(
        'layers2025-style',
        get_stylesheet_uri(),
        array( 'ferrotec-custom' ),
        LAYERS2025_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'layers2025_enqueue_styles' );

/**
 * Enqueue theme scripts
 */
function layers2025_enqueue_scripts() {
    // Bootstrap 5 Bundle (includes Popper)
    wp_enqueue_script(
        'bootstrap-bundle',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );

    // Navigation script
    if ( file_exists( LAYERS2025_DIR . '/assets/js/navigation.js' ) ) {
        wp_enqueue_script(
            'layers2025-navigation',
            LAYERS2025_URI . '/assets/js/navigation.js',
            array(),
            LAYERS2025_VERSION,
            true
        );
    }

    // Main scripts
    if ( file_exists( LAYERS2025_DIR . '/assets/js/scripts.js' ) ) {
        wp_enqueue_script(
            'layers2025-scripts',
            LAYERS2025_URI . '/assets/js/scripts.js',
            array( 'jquery' ),
            LAYERS2025_VERSION,
            true
        );

        // Localize script for AJAX
        wp_localize_script( 'layers2025-scripts', 'layers2025_vars', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'layers2025_nonce' ),
        ) );
    }

    // Comments reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'layers2025_enqueue_scripts' );

/**
 * Enqueue block editor styles
 */
function layers2025_block_editor_styles() {
    if ( file_exists( LAYERS2025_DIR . '/assets/css/block-editor.css' ) ) {
        wp_enqueue_style(
            'layers2025-block-editor-styles',
            LAYERS2025_URI . '/assets/css/block-editor.css',
            array(),
            LAYERS2025_VERSION
        );
    }
}
add_action( 'enqueue_block_editor_assets', 'layers2025_block_editor_styles' );
