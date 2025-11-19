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

/**
 * Register ACF Blocks
 *
 * Registers custom Gutenberg blocks powered by Advanced Custom Fields.
 * These blocks replace the old ACF repeater fields for a better editing experience.
 *
 * @since 1.0.0
 */
function layers2025_register_acf_blocks() {
    // Check if ACF function exists
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    /**
     * Content Section Block
     *
     * Replaces the old 'rows' repeater field.
     * Allows editors to add flexible content sections with optional background colors and classes.
     */
    acf_register_block_type( array(
        'name'              => 'content-section',
        'title'             => __( 'Content Section', 'layers2025' ),
        'description'       => __( 'A flexible content section with optional background color and CSS class', 'layers2025' ),
        'render_template'   => 'blocks/content-section/content-section.php',
        'category'          => 'formatting',
        'icon'              => 'layout',
        'keywords'          => array( 'content', 'section', 'container', 'row' ),
        'mode'              => 'preview',
        'supports'          => array(
            'align'             => array( 'wide', 'full' ),
            'anchor'            => true,
            'customClassName'   => true,
            'jsx'               => true,
        ),
        'example'  => array(
            'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    'content'           => '<h3>Example Content Section</h3><p>This is a flexible content section. You can add any HTML content here.</p>',
                    'background_class'  => 'bkg-gradient-green',
                ),
            ),
        ),
    ) );
}
add_action( 'acf/init', 'layers2025_register_acf_blocks' );

/**
 * Set ACF JSON save/load points for THEME fields
 *
 * Store ACF field groups as JSON in the theme for version control.
 *
 * IMPORTANT: This handles THEME-specific fields only (page/content presentation):
 * - Page banners (banner images, colors, text)
 * - Flexible content rows (page layout)
 * - Resource/event fields (if used in theme templates)
 *
 * PRODUCT DATA fields are handled by the ftc-product-ui plugin:
 * - Product specifications (thermal, seal, ferrofluid, meivac)
 * - Product files (CAD, datasheets)
 * - Performance data
 *
 * This separation allows product data to remain independent of the theme.
 *
 * @since 1.0.0
 */
function layers2025_acf_json_save_point( $path ) {
    // Save THEME field groups to theme/acf-json/
    return LAYERS2025_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'layers2025_acf_json_save_point', 5 );

function layers2025_acf_json_load_point( $paths ) {
    // Load THEME field groups from theme/acf-json/
    // Note: Plugin fields are loaded by ftc-product-ui at priority 10
    $paths[] = LAYERS2025_DIR . '/acf-json';
    return $paths;
}
add_filter( 'acf/settings/load_json', 'layers2025_acf_json_load_point', 5 );
