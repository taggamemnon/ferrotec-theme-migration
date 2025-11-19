<?php
/**
 * Product Tabs System
 *
 * Manages custom product tabs for WooCommerce products.
 * Integrates with feature flags to show/hide tabs per site.
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FTC_Tabs Class
 *
 * Handles registration and display of custom product tabs.
 */
class FTC_Tabs {

	/**
	 * Available tab definitions
	 *
	 * @var array
	 */
	private static $available_tabs = array();

	/**
	 * Initialize the tabs system
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		// Define available tabs
		self::define_tabs();

		// Hook into WooCommerce tabs filter
		add_filter( 'woocommerce_product_tabs', array( __CLASS__, 'add_custom_tabs' ), 98 );

		// Remove default description tab (we'll use custom tabs instead)
		add_filter( 'woocommerce_product_tabs', array( __CLASS__, 'remove_default_tabs' ), 99 );

		// Enqueue tab-specific assets
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_tab_assets' ) );
	}

	/**
	 * Define available tabs
	 *
	 * @since 1.0.0
	 */
	private static function define_tabs() {
		self::$available_tabs = array(
			'specs' => array(
				'title'    => __( 'Specifications', 'ftc-product-ui' ),
				'priority' => 10,
				'callback' => array( __CLASS__, 'render_specs_tab' ),
				'template' => 'tabs/specs.php',
			),
			'features' => array(
				'title'    => __( 'Features', 'ftc-product-ui' ),
				'priority' => 20,
				'callback' => array( __CLASS__, 'render_features_tab' ),
				'template' => 'tabs/features.php',
			),
			'modeling' => array(
				'title'    => __( 'Modeling', 'ftc-product-ui' ),
				'priority' => 30,
				'callback' => array( __CLASS__, 'render_modeling_tab' ),
				'template' => 'tabs/modeling.php',
				'sites'    => array( 'thermal' ), // Thermal-specific
			),
			'ordering' => array(
				'title'    => __( 'Ordering Information', 'ftc-product-ui' ),
				'priority' => 40,
				'callback' => array( __CLASS__, 'render_ordering_tab' ),
				'template' => 'tabs/ordering.php',
			),
			'downloads' => array(
				'title'    => __( 'Downloads', 'ftc-product-ui' ),
				'priority' => 50,
				'callback' => array( __CLASS__, 'render_downloads_tab' ),
				'template' => 'tabs/downloads.php',
			),
			'spare_parts' => array(
				'title'    => __( 'Spare Parts', 'ftc-product-ui' ),
				'priority' => 60,
				'callback' => array( __CLASS__, 'render_spare_parts_tab' ),
				'template' => 'tabs/spare-parts.php',
				'sites'    => array( 'seals' ), // Seals-specific
			),
		);

		/**
		 * Filter available tabs
		 *
		 * Allows themes or other plugins to modify available tabs.
		 *
		 * @since 1.0.0
		 * @param array $available_tabs Array of tab definitions.
		 */
		self::$available_tabs = apply_filters( 'ftc_available_product_tabs', self::$available_tabs );
	}

	/**
	 * Add custom tabs to WooCommerce
	 *
	 * @since 1.0.0
	 * @param array $tabs Existing WooCommerce tabs.
	 * @return array Modified tabs array.
	 */
	public static function add_custom_tabs( $tabs ) {
		global $product;

		if ( ! $product ) {
			return $tabs;
		}

		// Get enabled tabs from feature flags
		$enabled_tabs = FTC_Feature_Flags::get_enabled_tabs();

		foreach ( self::$available_tabs as $tab_key => $tab_data ) {
			// Check if tab is enabled via feature flags
			if ( ! in_array( $tab_key, $enabled_tabs ) ) {
				continue;
			}

			// Check site-specific restrictions
			if ( isset( $tab_data['sites'] ) && ! self::is_current_site( $tab_data['sites'] ) ) {
				continue;
			}

			// Check if tab has content (for optional tabs)
			if ( ! self::tab_has_content( $tab_key, $product ) ) {
				continue;
			}

			// Add tab to WooCommerce
			$tabs[ 'ftc_' . $tab_key ] = array(
				'title'    => $tab_data['title'],
				'priority' => $tab_data['priority'],
				'callback' => $tab_data['callback'],
			);
		}

		return $tabs;
	}

	/**
	 * Remove default WooCommerce tabs
	 *
	 * @since 1.0.0
	 * @param array $tabs Existing tabs.
	 * @return array Modified tabs.
	 */
	public static function remove_default_tabs( $tabs ) {
		// Remove default description tab (replaced by our custom tabs)
		unset( $tabs['description'] );

		// Keep reviews tab
		// unset( $tabs['reviews'] );

		// Remove additional information tab (we handle this in specs)
		unset( $tabs['additional_information'] );

		return $tabs;
	}

	/**
	 * Check if current site matches allowed sites
	 *
	 * @since 1.0.0
	 * @param array $allowed_sites Array of site slugs.
	 * @return bool True if current site is allowed.
	 */
	private static function is_current_site( $allowed_sites ) {
		if ( ! is_multisite() ) {
			return true;
		}

		$current_site = get_site()->domain;

		foreach ( $allowed_sites as $site_slug ) {
			if ( strpos( $current_site, $site_slug ) !== false ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a tab has content to display
	 *
	 * @since 1.0.0
	 * @param string $tab_key Tab identifier.
	 * @param WC_Product $product Product object.
	 * @return bool True if tab has content.
	 */
	private static function tab_has_content( $tab_key, $product ) {
		// Always show specs and features
		if ( in_array( $tab_key, array( 'specs', 'features' ) ) ) {
			return true;
		}

		// Show modeling tab only for thermal products with performance data
		if ( $tab_key === 'modeling' ) {
			$has_thermal_cat = has_term(
				array( 'thermal-modules', 'peltier-coolers' ),
				'product_cat',
				$product->get_id()
			);
			$has_performance_data = get_field( 'thermal_performance_data', $product->get_id() );

			return $has_thermal_cat && ! empty( $has_performance_data );
		}

		// Show downloads tab only if files exist
		if ( $tab_key === 'downloads' ) {
			$datasheet = get_field( 'product_datasheet', $product->get_id() );
			$cad_file = get_field( 'product_cad_file', $product->get_id() );

			return ! empty( $datasheet ) || ! empty( $cad_file );
		}

		// Show spare parts tab only for seals with spare parts data
		if ( $tab_key === 'spare_parts' ) {
			$spare_parts = get_field( 'seal_spare_parts', $product->get_id() );

			return ! empty( $spare_parts );
		}

		// Show ordering tab if product is orderable or has ordering info
		if ( $tab_key === 'ordering' ) {
			$ordering_info = get_field( 'product_ordering_info', $product->get_id() );

			return $product->is_purchasable() || ! empty( $ordering_info );
		}

		// Default: show tab
		return true;
	}

	/**
	 * Render Specifications tab
	 *
	 * @since 1.0.0
	 */
	public static function render_specs_tab() {
		self::render_template( 'tabs/specs.php' );
	}

	/**
	 * Render Features tab
	 *
	 * @since 1.0.0
	 */
	public static function render_features_tab() {
		self::render_template( 'tabs/features.php' );
	}

	/**
	 * Render Modeling tab
	 *
	 * @since 1.0.0
	 */
	public static function render_modeling_tab() {
		self::render_template( 'tabs/modeling.php' );
	}

	/**
	 * Render Ordering Information tab
	 *
	 * @since 1.0.0
	 */
	public static function render_ordering_tab() {
		self::render_template( 'tabs/ordering.php' );
	}

	/**
	 * Render Downloads tab
	 *
	 * @since 1.0.0
	 */
	public static function render_downloads_tab() {
		self::render_template( 'tabs/downloads.php' );
	}

	/**
	 * Render Spare Parts tab
	 *
	 * @since 1.0.0
	 */
	public static function render_spare_parts_tab() {
		self::render_template( 'tabs/spare-parts.php' );
	}

	/**
	 * Render a template file
	 *
	 * @since 1.0.0
	 * @param string $template_name Template file name (relative to templates/).
	 */
	private static function render_template( $template_name ) {
		global $product;

		// Allow themes to override templates
		$template = locate_template( array(
			'ftc-product-ui/' . $template_name,
			'woocommerce/' . $template_name,
		) );

		// Use plugin template if not found in theme
		if ( ! $template ) {
			$template = FTC_PRODUCT_UI_PATH . 'templates/' . $template_name;
		}

		// Check if template exists
		if ( file_exists( $template ) ) {
			include $template;
		} else {
			echo '<p>' . esc_html__( 'Template not found.', 'ftc-product-ui' ) . '</p>';
		}
	}

	/**
	 * Enqueue tab-specific assets
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_tab_assets() {
		if ( ! is_product() ) {
			return;
		}

		global $product;

		// Enqueue Chart.js for modeling tab
		$enabled_tabs = FTC_Feature_Flags::get_enabled_tabs();

		if ( in_array( 'modeling', $enabled_tabs ) ) {
			$has_thermal_cat = has_term(
				array( 'thermal-modules', 'peltier-coolers' ),
				'product_cat',
				$product->get_id()
			);

			if ( $has_thermal_cat ) {
				wp_enqueue_script(
					'chartjs',
					'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js',
					array(),
					'4.4.0',
					true
				);
			}
		}

		// Enqueue custom tab styles
		wp_enqueue_style(
			'ftc-product-tabs',
			FTC_PRODUCT_UI_URL . 'assets/css/product-tabs.css',
			array(),
			FTC_PRODUCT_UI_VERSION
		);

		// Enqueue custom tab scripts
		wp_enqueue_script(
			'ftc-product-tabs',
			FTC_PRODUCT_UI_URL . 'assets/js/product-tabs.js',
			array( 'jquery' ),
			FTC_PRODUCT_UI_VERSION,
			true
		);
	}

	/**
	 * Get available tabs
	 *
	 * @since 1.0.0
	 * @return array Available tabs.
	 */
	public static function get_available_tabs() {
		if ( empty( self::$available_tabs ) ) {
			self::define_tabs();
		}

		return self::$available_tabs;
	}
}
