<?php
/**
 * Theme Setup Functions
 *
 * @package Layers2025
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function layers2025_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_theme_textdomain( 'layers2025', LAYERS2025_DIR . '/languages' );

    /*
     * Add default posts and comments RSS feed links to head.
     */
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support( 'post-thumbnails' );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    /*
     * Add theme support for selective refresh for widgets.
     */
    add_theme_support( 'customize-selective-refresh-widgets' );

    /*
     * Add support for core custom logo.
     */
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    /*
     * Add support for wide and full alignment for blocks.
     */
    add_theme_support( 'align-wide' );

    /*
     * Add support for responsive embedded content.
     */
    add_theme_support( 'responsive-embeds' );

    /*
     * Add support for editor styles.
     */
    add_theme_support( 'editor-styles' );

    /*
     * Add WooCommerce support
     */
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    /*
     * Register navigation menus.
     */
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'layers2025' ),
        'mobile'  => __( 'Mobile Menu', 'layers2025' ),
        'footer'  => __( 'Footer Menu', 'layers2025' ),
    ) );
}
add_action( 'after_setup_theme', 'layers2025_setup' );

/**
 * Register widget areas.
 */
function layers2025_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'layers2025' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'layers2025' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'layers2025' ),
        'id'            => 'footer-1',
        'description'   => __( 'Add widgets here to appear in your footer.', 'layers2025' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'layers2025' ),
        'id'            => 'footer-2',
        'description'   => __( 'Add widgets here to appear in your footer.', 'layers2025' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'layers2025' ),
        'id'            => 'footer-3',
        'description'   => __( 'Add widgets here to appear in your footer.', 'layers2025' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'layers2025_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 */
function layers2025_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'layers2025_content_width', 1140 );
}
add_action( 'after_setup_theme', 'layers2025_content_width', 0 );
