<?php
/**
 * Feature Flags System
 *
 * Per-site tab configuration for multisite
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * FTC Feature Flags Class
 */
class FTC_Feature_Flags {

    /**
     * Available tabs
     *
     * @var array
     */
    private static $available_tabs = array(
        'specs'       => 'Specifications',
        'features'    => 'Features',
        'modeling'    => 'Modeling',
        'ordering'    => 'Ordering',
        'downloads'   => 'Downloads',
        'spare_parts' => 'Spare Parts',
        'quote'       => 'Request Quote',
        'cad'         => 'CAD Models',
    );

    /**
     * Check if a tab is enabled for current site
     *
     * @param string $tab_slug The tab slug.
     * @return bool
     */
    public static function tab_enabled( $tab_slug ) {
        // Multisite support
        if ( is_multisite() ) {
            $blog_id = get_current_blog_id();
            $enabled_tabs = get_blog_option( $blog_id, 'ftc_tabs', array() );
        } else {
            $enabled_tabs = get_option( 'ftc_tabs', array() );
        }

        return isset( $enabled_tabs[ $tab_slug ] ) && $enabled_tabs[ $tab_slug ];
    }

    /**
     * Get all enabled tabs for current site
     *
     * @return array
     */
    public static function get_enabled_tabs() {
        $enabled = array();

        foreach ( self::$available_tabs as $slug => $label ) {
            if ( self::tab_enabled( $slug ) ) {
                $enabled[ $slug ] = $label;
            }
        }

        return $enabled;
    }

    /**
     * Get all available tabs
     *
     * @return array
     */
    public static function get_available_tabs() {
        return self::$available_tabs;
    }

    /**
     * Update feature flags for a site
     *
     * @param array $tabs Array of tab slugs => enabled status.
     * @param int   $blog_id Optional blog ID (multisite).
     * @return bool
     */
    public static function update_tabs( $tabs, $blog_id = null ) {
        if ( is_multisite() && $blog_id ) {
            return update_blog_option( $blog_id, 'ftc_tabs', $tabs );
        }

        return update_option( 'ftc_tabs', $tabs );
    }

    /**
     * Get default tab configuration
     *
     * @return array
     */
    public static function get_default_tabs() {
        return array(
            'specs'       => true,
            'features'    => true,
            'modeling'    => false,  // Only Thermal
            'ordering'    => true,
            'downloads'   => true,
            'spare_parts' => false,
            'quote'       => true,
            'cad'         => false,
        );
    }

    /**
     * Get site-specific defaults based on domain
     *
     * @param string $domain The site domain.
     * @return array
     */
    public static function get_site_defaults( $domain = '' ) {
        if ( empty( $domain ) ) {
            $domain = $_SERVER['HTTP_HOST'] ?? '';
        }

        $defaults = self::get_default_tabs();

        // Thermal site gets Modeling tab
        if ( strpos( $domain, 'thermal.ferrotec.com' ) !== false ) {
            $defaults['modeling'] = true;
        }

        // Seals site gets Spare Parts tab
        if ( strpos( $domain, 'seals.ferrotec.com' ) !== false ) {
            $defaults['spare_parts'] = true;
        }

        // Info-only sites (no ordering)
        $info_only_sites = array(
            'www.ferrotec.com',
            'quartz.ferrotec.com',
            'ceramics.ferrotec.com',
            'temescal.ferrotec.com',
        );

        if ( in_array( $domain, $info_only_sites, true ) ) {
            $defaults['ordering'] = false;
            $defaults['quote'] = false;
        }

        return $defaults;
    }
}
