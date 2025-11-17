<?php
/**
 * Layers 2025 Theme Functions
 *
 * @package Layers2025
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define theme constants
 */
define( 'LAYERS2025_VERSION', '1.0.0' );
define( 'LAYERS2025_DIR', get_template_directory() );
define( 'LAYERS2025_URI', get_template_directory_uri() );

/**
 * Load theme setup and configuration
 */
require_once LAYERS2025_DIR . '/inc/theme-setup.php';

/**
 * Load script and style enqueuing
 */
require_once LAYERS2025_DIR . '/inc/enqueue-scripts.php';

/**
 * Load navigation functions
 */
require_once LAYERS2025_DIR . '/inc/navigation.php';

/**
 * Load custom template tags
 */
require_once LAYERS2025_DIR . '/inc/template-tags.php';

/**
 * Load customizer additions
 */
if ( file_exists( LAYERS2025_DIR . '/inc/customizer.php' ) ) {
    require_once LAYERS2025_DIR . '/inc/customizer.php';
}

/**
 * Load WooCommerce compatibility file if WooCommerce is active
 */
if ( class_exists( 'WooCommerce' ) ) {
    if ( file_exists( LAYERS2025_DIR . '/inc/woocommerce.php' ) ) {
        require_once LAYERS2025_DIR . '/inc/woocommerce.php';
    }
}

/**
 * Content width
 *
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 1140; // pixels
}
