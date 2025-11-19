<?php
/**
 * Admin Class
 *
 * Handles all admin-facing functionality
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FTC Admin Class
 */
class FTC_Admin {

	/**
	 * Initialize admin functionality
	 */
	public static function init() {
		$instance = new self();
		$instance->init_hooks();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		// Admin menu
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

		// Network admin menu (for multisite)
		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'add_network_admin_menu' ) );
		}

		// Register settings
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Enqueue admin assets
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

		// AJAX handlers
		add_action( 'wp_ajax_ftc_save_feature_flags', array( $this, 'ajax_save_feature_flags' ) );
	}

	/**
	 * Add admin menu
	 */
	public function add_admin_menu() {
		add_menu_page(
			__( 'FTC Product UI', 'ftc-product-ui' ),
			__( 'FTC Product UI', 'ftc-product-ui' ),
			'manage_options',
			'ftc-product-ui',
			array( $this, 'render_settings_page' ),
			'dashicons-products',
			58
		);

		add_submenu_page(
			'ftc-product-ui',
			__( 'Feature Flags', 'ftc-product-ui' ),
			__( 'Feature Flags', 'ftc-product-ui' ),
			'manage_options',
			'ftc-product-ui',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Add network admin menu (multisite)
	 */
	public function add_network_admin_menu() {
		add_menu_page(
			__( 'FTC Product UI', 'ftc-product-ui' ),
			__( 'FTC Product UI', 'ftc-product-ui' ),
			'manage_network_options',
			'ftc-product-ui-network',
			array( $this, 'render_network_settings_page' ),
			'dashicons-products',
			58
		);
	}

	/**
	 * Register settings
	 */
	public function register_settings() {
		register_setting(
			'ftc_product_ui_settings',
			'ftc_tabs',
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_tabs' ),
				'default'           => FTC_Feature_Flags::get_default_tabs(),
			)
		);
	}

	/**
	 * Sanitize tabs settings
	 *
	 * @param array $input The input array.
	 * @return array
	 */
	public function sanitize_tabs( $input ) {
		$sanitized = array();
		$available_tabs = FTC_Feature_Flags::get_available_tabs();

		foreach ( $available_tabs as $slug => $label ) {
			$sanitized[ $slug ] = isset( $input[ $slug ] ) && $input[ $slug ] === '1';
		}

		return $sanitized;
	}

	/**
	 * Enqueue admin assets
	 *
	 * @param string $hook The current admin page hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		// Only load on our admin pages
		if ( strpos( $hook, 'ftc-product-ui' ) === false ) {
			return;
		}

		// Admin CSS
		wp_enqueue_style(
			'ftc-admin',
			FTC_PRODUCT_UI_URL . 'admin/assets/css/admin.css',
			array(),
			FTC_PRODUCT_UI_VERSION
		);

		// Admin JS
		wp_enqueue_script(
			'ftc-admin',
			FTC_PRODUCT_UI_URL . 'admin/assets/js/admin.js',
			array( 'jquery' ),
			FTC_PRODUCT_UI_VERSION,
			true
		);

		// Localize script
		wp_localize_script( 'ftc-admin', 'ftcAdmin', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'ftc_admin_nonce' ),
			'strings' => array(
				'saved'       => __( 'Settings saved successfully!', 'ftc-product-ui' ),
				'error'       => __( 'Error saving settings. Please try again.', 'ftc-product-ui' ),
				'confirm'     => __( 'Are you sure you want to reset to defaults?', 'ftc-product-ui' ),
			),
		) );
	}

	/**
	 * Render settings page
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'ftc-product-ui' ) );
		}

		// Get current site info
		$site_url = get_site_url();
		$site_name = get_bloginfo( 'name' );
		$current_tabs = get_option( 'ftc_tabs', FTC_Feature_Flags::get_default_tabs() );
		$available_tabs = FTC_Feature_Flags::get_available_tabs();

		// Include view
		include FTC_PRODUCT_UI_DIR . 'admin/views/feature-flags.php';
	}

	/**
	 * Render network settings page (multisite)
	 */
	public function render_network_settings_page() {
		if ( ! current_user_can( 'manage_network_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'ftc-product-ui' ) );
		}

		// Get all sites
		$sites = get_sites( array( 'number' => 0 ) );
		$available_tabs = FTC_Feature_Flags::get_available_tabs();

		// Include network view
		include FTC_PRODUCT_UI_DIR . 'admin/views/network-settings.php';
	}

	/**
	 * AJAX handler to save feature flags
	 */
	public function ajax_save_feature_flags() {
		// Check nonce
		check_ajax_referer( 'ftc_admin_nonce', 'nonce' );

		// Check permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Insufficient permissions.', 'ftc-product-ui' ) ) );
		}

		// Get tabs data
		$tabs = isset( $_POST['tabs'] ) ? $_POST['tabs'] : array();

		// Sanitize
		$sanitized_tabs = $this->sanitize_tabs( $tabs );

		// Update option
		$updated = update_option( 'ftc_tabs', $sanitized_tabs );

		if ( $updated ) {
			wp_send_json_success( array(
				'message' => __( 'Feature flags saved successfully!', 'ftc-product-ui' ),
				'tabs'    => $sanitized_tabs,
			) );
		} else {
			wp_send_json_error( array( 'message' => __( 'No changes were made.', 'ftc-product-ui' ) ) );
		}
	}
}
