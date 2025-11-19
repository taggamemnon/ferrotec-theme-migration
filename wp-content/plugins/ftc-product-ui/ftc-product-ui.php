<?php
/**
 * Plugin Name: FTC Product UI
 * Plugin URI: https://ferrotec.com
 * Description: Network-activated product display system for Ferrotec multisite with tabs, charts, and print views
 * Version: 1.0.0
 * Author: Tagg Swift
 * Author URI: https://auc.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network: true
 * Requires PHP: 8.0
 * Requires at least: 6.0
 * Text Domain: ftc-product-ui
 * Domain Path: /languages
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin version
define( 'FTC_PRODUCT_UI_VERSION', '1.0.0' );

// Plugin paths
define( 'FTC_PRODUCT_UI_FILE', __FILE__ );
define( 'FTC_PRODUCT_UI_DIR', plugin_dir_path( __FILE__ ) );
define( 'FTC_PRODUCT_UI_URL', plugin_dir_url( __FILE__ ) );
define( 'FTC_PRODUCT_UI_BASENAME', plugin_basename( __FILE__ ) );

// Check if WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) &&
     ! array_key_exists( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_site_option( 'active_sitewide_plugins', array() ) ) ) ) {

    // Show admin notice if WooCommerce is not active
    add_action( 'admin_notices', 'ftc_product_ui_woocommerce_missing_notice' );
    add_action( 'network_admin_notices', 'ftc_product_ui_woocommerce_missing_notice' );

    function ftc_product_ui_woocommerce_missing_notice() {
        echo '<div class="error"><p>';
        echo '<strong>FTC Product UI</strong> requires WooCommerce to be installed and active.';
        echo '</p></div>';
    }

    return;
}

/**
 * Autoloader for plugin classes
 *
 * @param string $class The class name.
 */
function ftc_product_ui_autoloader( $class ) {
    // Check if class starts with FTC_
    if ( strpos( $class, 'FTC_' ) !== 0 ) {
        return;
    }

    // Convert class name to file name
    $file = FTC_PRODUCT_UI_DIR . 'includes/class-' . strtolower( str_replace( '_', '-', $class ) ) . '.php';

    if ( file_exists( $file ) ) {
        require_once $file;
    }
}
spl_autoload_register( 'ftc_product_ui_autoloader' );

/**
 * Main FTC Product UI Class
 *
 * @since 1.0.0
 */
final class FTC_Product_UI {

    /**
     * The single instance of the class
     *
     * @var FTC_Product_UI
     */
    protected static $_instance = null;

    /**
     * Main instance
     *
     * @return FTC_Product_UI
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->init_hooks();
    }

    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action( 'init', array( $this, 'init' ), 0 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        // ACF JSON save/load points
        add_filter( 'acf/settings/save_json', array( $this, 'acf_json_save_point' ) );
        add_filter( 'acf/settings/load_json', array( $this, 'acf_json_load_point' ) );
    }

    /**
     * Initialize plugin
     */
    public function init() {
        // Load text domain
        load_plugin_textdomain( 'ftc-product-ui', false, dirname( FTC_PRODUCT_UI_BASENAME ) . '/languages' );

        // Initialize plugin components
        $this->init_components();
    }

    /**
     * Initialize plugin components
     */
    private function init_components() {
        // Only load on product-related pages for performance
        if ( ! is_admin() ) {
            // Load on product pages, shop pages, or if WooCommerce is in query
            if ( is_product() || is_shop() || is_product_category() || is_product_tag() || is_cart() || is_checkout() ) {
                $this->load_frontend_components();
            }
        } else {
            // Load admin components
            $this->load_admin_components();
        }
    }

    /**
     * Load frontend components
     */
    private function load_frontend_components() {
        // Feature flags
        if ( file_exists( FTC_PRODUCT_UI_DIR . 'includes/class-ftc-feature-flags.php' ) ) {
            require_once FTC_PRODUCT_UI_DIR . 'includes/class-ftc-feature-flags.php';
        }

        // Product tabs
        if ( file_exists( FTC_PRODUCT_UI_DIR . 'includes/class-ftc-tabs.php' ) ) {
            require_once FTC_PRODUCT_UI_DIR . 'includes/class-ftc-tabs.php';
            FTC_Tabs::init();
        }

        // Product attributes
        if ( file_exists( FTC_PRODUCT_UI_DIR . 'includes/class-ftc-attributes.php' ) ) {
            require_once FTC_PRODUCT_UI_DIR . 'includes/class-ftc-attributes.php';
            FTC_Attributes::init();
        }

        // Shortcodes
        if ( file_exists( FTC_PRODUCT_UI_DIR . 'includes/class-ftc-shortcodes.php' ) ) {
            require_once FTC_PRODUCT_UI_DIR . 'includes/class-ftc-shortcodes.php';
            FTC_Shortcodes::init();
        }

        // Print view
        if ( file_exists( FTC_PRODUCT_UI_DIR . 'includes/class-ftc-print-view.php' ) ) {
            require_once FTC_PRODUCT_UI_DIR . 'includes/class-ftc-print-view.php';
            FTC_Print_View::init();
        }

        // Charts
        if ( file_exists( FTC_PRODUCT_UI_DIR . 'includes/class-ftc-charts.php' ) ) {
            require_once FTC_PRODUCT_UI_DIR . 'includes/class-ftc-charts.php';
            FTC_Charts::init();
        }
    }

    /**
     * Load admin components
     */
    private function load_admin_components() {
        if ( file_exists( FTC_PRODUCT_UI_DIR . 'admin/class-ftc-admin.php' ) ) {
            require_once FTC_PRODUCT_UI_DIR . 'admin/class-ftc-admin.php';
            FTC_Admin::init();
        }
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        // Only enqueue on product pages
        if ( ! ( is_product() || is_shop() || is_product_category() ) ) {
            return;
        }

        // Main plugin styles
        wp_enqueue_style(
            'ftc-product-ui',
            FTC_PRODUCT_UI_URL . 'assets/css/ftc-main.css',
            array(),
            FTC_PRODUCT_UI_VERSION
        );

        // Main plugin scripts
        wp_enqueue_script(
            'ftc-product-ui',
            FTC_PRODUCT_UI_URL . 'assets/js/ftc-main.js',
            array( 'jquery' ),
            FTC_PRODUCT_UI_VERSION,
            true
        );

        // Localize script
        wp_localize_script( 'ftc-product-ui', 'ftcProductUI', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'ftc_product_ui_nonce' ),
        ) );
    }

    /**
     * ACF JSON save point
     *
     * @param string $path The path to save ACF JSON files.
     * @return string
     */
    public function acf_json_save_point( $path ) {
        return FTC_PRODUCT_UI_DIR . 'acf-json';
    }

    /**
     * ACF JSON load point
     *
     * @param array $paths Array of paths to load ACF JSON files from.
     * @return array
     */
    public function acf_json_load_point( $paths ) {
        $paths[] = FTC_PRODUCT_UI_DIR . 'acf-json';
        return $paths;
    }
}

/**
 * Returns the main instance of FTC_Product_UI
 *
 * @return FTC_Product_UI
 */
function FTC_Product_UI() {
    return FTC_Product_UI::instance();
}

// Initialize plugin
add_action( 'plugins_loaded', 'FTC_Product_UI' );

/**
 * Plugin activation hook
 */
function ftc_product_ui_activate( $network_wide ) {
    if ( ! is_multisite() || ! $network_wide ) {
        ftc_product_ui_single_site_activate();
        return;
    }

    // Network activation - activate on all sites
    $sites = get_sites( array( 'number' => 0 ) );
    foreach ( $sites as $site ) {
        switch_to_blog( $site->blog_id );
        ftc_product_ui_single_site_activate();
        restore_current_blog();
    }
}
register_activation_hook( __FILE__, 'ftc_product_ui_activate' );

/**
 * Single site activation
 */
function ftc_product_ui_single_site_activate() {
    // Set default feature flags
    $default_tabs = array(
        'specs'       => true,
        'features'    => true,
        'modeling'    => false,  // Only Thermal by default
        'ordering'    => true,
        'downloads'   => true,
        'spare_parts' => false,
        'quote'       => true,
        'cad'         => false,
    );

    add_option( 'ftc_tabs', $default_tabs );
    add_option( 'ftc_product_ui_version', FTC_PRODUCT_UI_VERSION );

    // Flush rewrite rules
    flush_rewrite_rules();
}

/**
 * Plugin deactivation hook
 */
function ftc_product_ui_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'ftc_product_ui_deactivate' );
