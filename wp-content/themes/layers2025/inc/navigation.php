<?php
/**
 * Navigation Functions
 *
 * @package Layers2025
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display the primary navigation menu
 */
function layers2025_primary_navigation() {
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
            'theme_location'  => 'primary',
            'menu_id'         => 'primary-menu',
            'menu_class'      => 'primary-menu',
            'container'       => 'nav',
            'container_class' => 'main-navigation',
            'container_id'    => 'site-navigation',
            'fallback_cb'     => false,
        ) );
    }
}

/**
 * Display the mobile navigation menu
 */
function layers2025_mobile_navigation() {
    if ( has_nav_menu( 'mobile' ) ) {
        wp_nav_menu( array(
            'theme_location'  => 'mobile',
            'menu_id'         => 'mobile-menu',
            'menu_class'      => 'mobile-menu',
            'container'       => 'nav',
            'container_class' => 'mobile-navigation',
            'container_id'    => 'mobile-navigation',
            'fallback_cb'     => false,
        ) );
    }
}

/**
 * Display the footer navigation menu
 */
function layers2025_footer_navigation() {
    if ( has_nav_menu( 'footer' ) ) {
        wp_nav_menu( array(
            'theme_location'  => 'footer',
            'menu_id'         => 'footer-menu',
            'menu_class'      => 'footer-menu',
            'container'       => 'nav',
            'container_class' => 'footer-navigation',
            'container_id'    => 'footer-navigation',
            'depth'           => 1,
            'fallback_cb'     => false,
        ) );
    }
}

/**
 * Add custom CSS classes to menu items
 */
function layers2025_nav_menu_css_class( $classes, $item, $args, $depth ) {
    // Add depth class
    $classes[] = 'menu-item-depth-' . $depth;

    // Add parent class if item has children
    if ( in_array( 'menu-item-has-children', $classes ) ) {
        $classes[] = 'has-submenu';
    }

    return $classes;
}
add_filter( 'nav_menu_css_class', 'layers2025_nav_menu_css_class', 10, 4 );

/**
 * Add custom attributes to menu links
 */
function layers2025_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    // Add aria-current to current page
    if ( in_array( 'current-menu-item', $item->classes ) ) {
        $atts['aria-current'] = 'page';
    }

    // Add aria-haspopup to parent items
    if ( in_array( 'menu-item-has-children', $item->classes ) ) {
        $atts['aria-haspopup'] = 'true';
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'layers2025_nav_menu_link_attributes', 10, 4 );
