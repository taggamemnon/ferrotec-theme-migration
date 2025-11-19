<?php
/**
 * Feature Flags Settings Page
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 *
 * @var string $site_url Current site URL
 * @var string $site_name Current site name
 * @var array $current_tabs Current tab settings
 * @var array $available_tabs Available tabs
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap ftc-admin-wrap">
	<h1 class="ftc-admin-title">
		<?php echo esc_html( get_admin_page_title() ); ?>
	</h1>

	<div class="ftc-admin-header">
		<p class="ftc-site-info">
			<strong><?php esc_html_e( 'Site:', 'ftc-product-ui' ); ?></strong>
			<?php echo esc_html( $site_name ); ?>
			<span class="ftc-site-url">(<?php echo esc_html( $site_url ); ?>)</span>
		</p>
	</div>

	<?php settings_errors(); ?>

	<div class="ftc-admin-container">
		<div class="ftc-admin-main">
			<form method="post" action="options.php" id="ftc-feature-flags-form">
				<?php settings_fields( 'ftc_product_ui_settings' ); ?>

				<div class="ftc-card">
					<div class="ftc-card-header">
						<h2><?php esc_html_e( 'Product Tabs Configuration', 'ftc-product-ui' ); ?></h2>
						<p class="description">
							<?php esc_html_e( 'Enable or disable product tabs for this site. Changes will take effect immediately on the frontend.', 'ftc-product-ui' ); ?>
						</p>
					</div>

					<div class="ftc-card-body">
						<table class="form-table ftc-tabs-table" role="presentation">
							<tbody>
								<?php foreach ( $available_tabs as $slug => $label ) : ?>
									<?php
									$checked = isset( $current_tabs[ $slug ] ) && $current_tabs[ $slug ];
									$description = $this->get_tab_description( $slug );
									$badge = $this->get_tab_badge( $slug );
									?>
									<tr>
										<th scope="row">
											<label for="ftc_tab_<?php echo esc_attr( $slug ); ?>">
												<?php echo esc_html( $label ); ?>
												<?php if ( $badge ) : ?>
													<span class="ftc-badge ftc-badge-<?php echo esc_attr( $badge['type'] ); ?>">
														<?php echo esc_html( $badge['text'] ); ?>
													</span>
												<?php endif; ?>
											</label>
										</th>
										<td>
											<label class="ftc-toggle">
												<input
													type="checkbox"
													id="ftc_tab_<?php echo esc_attr( $slug ); ?>"
													name="ftc_tabs[<?php echo esc_attr( $slug ); ?>]"
													value="1"
													<?php checked( $checked ); ?>
												>
												<span class="ftc-toggle-slider"></span>
											</label>
											<?php if ( $description ) : ?>
												<p class="description"><?php echo esc_html( $description ); ?></p>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>

					<div class="ftc-card-footer">
						<?php submit_button( __( 'Save Changes', 'ftc-product-ui' ), 'primary', 'submit', false ); ?>
						<button type="button" class="button ftc-reset-defaults" id="ftc-reset-defaults">
							<?php esc_html_e( 'Reset to Site Defaults', 'ftc-product-ui' ); ?>
						</button>
					</div>
				</div>
			</form>

			<div class="ftc-card ftc-info-card">
				<div class="ftc-card-header">
					<h3><?php esc_html_e( 'Tab Information', 'ftc-product-ui' ); ?></h3>
				</div>
				<div class="ftc-card-body">
					<dl class="ftc-tab-info">
						<dt><?php esc_html_e( 'Specifications', 'ftc-product-ui' ); ?></dt>
						<dd><?php esc_html_e( 'Display product specifications and technical attributes in a table format.', 'ftc-product-ui' ); ?></dd>

						<dt><?php esc_html_e( 'Features', 'ftc-product-ui' ); ?></dt>
						<dd><?php esc_html_e( 'Showcase product features and benefits with custom content.', 'ftc-product-ui' ); ?></dd>

						<dt><?php esc_html_e( 'Modeling', 'ftc-product-ui' ); ?></dt>
						<dd><?php esc_html_e( 'Display performance charts and modeling data (typically for Thermal products only).', 'ftc-product-ui' ); ?></dd>

						<dt><?php esc_html_e( 'Ordering', 'ftc-product-ui' ); ?></dt>
						<dd><?php esc_html_e( 'Show ordering information and forms for product purchases.', 'ftc-product-ui' ); ?></dd>

						<dt><?php esc_html_e( 'Downloads', 'ftc-product-ui' ); ?></dt>
						<dd><?php esc_html_e( 'Provide CAD files, datasheets, and other downloadable resources.', 'ftc-product-ui' ); ?></dd>

						<dt><?php esc_html_e( 'Spare Parts', 'ftc-product-ui' ); ?></dt>
						<dd><?php esc_html_e( 'List replacement parts and accessories for the product.', 'ftc-product-ui' ); ?></dd>

						<dt><?php esc_html_e( 'Request Quote', 'ftc-product-ui' ); ?></dt>
						<dd><?php esc_html_e( 'Display a quote request form for custom pricing inquiries.', 'ftc-product-ui' ); ?></dd>

						<dt><?php esc_html_e( 'CAD Models', 'ftc-product-ui' ); ?></dt>
						<dd><?php esc_html_e( '3D CAD model viewer for interactive product visualization.', 'ftc-product-ui' ); ?></dd>
					</dl>
				</div>
			</div>
		</div>

		<div class="ftc-admin-sidebar">
			<div class="ftc-card ftc-status-card">
				<div class="ftc-card-header">
					<h3><?php esc_html_e( 'Status', 'ftc-product-ui' ); ?></h3>
				</div>
				<div class="ftc-card-body">
					<p class="ftc-status-item">
						<span class="dashicons dashicons-yes-alt"></span>
						<strong><?php esc_html_e( 'Plugin Version:', 'ftc-product-ui' ); ?></strong>
						<?php echo esc_html( FTC_PRODUCT_UI_VERSION ); ?>
					</p>
					<p class="ftc-status-item">
						<span class="dashicons dashicons-admin-multisite"></span>
						<strong><?php esc_html_e( 'Multisite:', 'ftc-product-ui' ); ?></strong>
						<?php echo is_multisite() ? esc_html__( 'Yes', 'ftc-product-ui' ) : esc_html__( 'No', 'ftc-product-ui' ); ?>
					</p>
					<p class="ftc-status-item">
						<span class="dashicons dashicons-cart"></span>
						<strong><?php esc_html_e( 'WooCommerce:', 'ftc-product-ui' ); ?></strong>
						<?php echo class_exists( 'WooCommerce' ) ? esc_html__( 'Active', 'ftc-product-ui' ) : esc_html__( 'Inactive', 'ftc-product-ui' ); ?>
					</p>
					<p class="ftc-status-item">
						<span class="dashicons dashicons-admin-plugins"></span>
						<strong><?php esc_html_e( 'ACF Pro:', 'ftc-product-ui' ); ?></strong>
						<?php echo class_exists( 'ACF' ) ? esc_html__( 'Active', 'ftc-product-ui' ) : esc_html__( 'Inactive', 'ftc-product-ui' ); ?>
					</p>
				</div>
			</div>

			<div class="ftc-card">
				<div class="ftc-card-header">
					<h3><?php esc_html_e( 'Quick Stats', 'ftc-product-ui' ); ?></h3>
				</div>
				<div class="ftc-card-body">
					<?php
					$enabled_count = count( array_filter( $current_tabs ) );
					$total_count = count( $available_tabs );
					?>
					<div class="ftc-stat">
						<div class="ftc-stat-number"><?php echo esc_html( $enabled_count ); ?> / <?php echo esc_html( $total_count ); ?></div>
						<div class="ftc-stat-label"><?php esc_html_e( 'Enabled Tabs', 'ftc-product-ui' ); ?></div>
					</div>
				</div>
			</div>

			<div class="ftc-card ftc-help-card">
				<div class="ftc-card-header">
					<h3><?php esc_html_e( 'Need Help?', 'ftc-product-ui' ); ?></h3>
				</div>
				<div class="ftc-card-body">
					<p><?php esc_html_e( 'For more information about configuring product tabs, see the documentation.', 'ftc-product-ui' ); ?></p>
					<p>
						<a href="<?php echo esc_url( FTC_PRODUCT_UI_URL . 'README.md' ); ?>" class="button button-secondary" target="_blank">
							<?php esc_html_e( 'View Documentation', 'ftc-product-ui' ); ?>
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
/**
 * Get tab description
 *
 * @param string $slug Tab slug.
 * @return string
 */
function get_tab_description( $slug ) {
	$descriptions = array(
		'specs'       => __( 'Display product specifications and attributes', 'ftc-product-ui' ),
		'features'    => __( 'Show product features and benefits', 'ftc-product-ui' ),
		'modeling'    => __( 'Performance charts and modeling data', 'ftc-product-ui' ),
		'ordering'    => __( 'Ordering information and forms', 'ftc-product-ui' ),
		'downloads'   => __( 'CAD files, datasheets, and resources', 'ftc-product-ui' ),
		'spare_parts' => __( 'Replacement parts and accessories', 'ftc-product-ui' ),
		'quote'       => __( 'Quote request form', 'ftc-product-ui' ),
		'cad'         => __( '3D CAD model viewer', 'ftc-product-ui' ),
	);

	return isset( $descriptions[ $slug ] ) ? $descriptions[ $slug ] : '';
}

/**
 * Get tab badge
 *
 * @param string $slug Tab slug.
 * @return array|null
 */
function get_tab_badge( $slug ) {
	// Check if this is thermal site
	$is_thermal = strpos( get_site_url(), 'thermal.ferrotec.com' ) !== false;
	$is_seals = strpos( get_site_url(), 'seals.ferrotec.com' ) !== false;

	if ( $slug === 'modeling' && $is_thermal ) {
		return array(
			'type' => 'recommended',
			'text' => __( 'Recommended', 'ftc-product-ui' ),
		);
	}

	if ( $slug === 'spare_parts' && $is_seals ) {
		return array(
			'type' => 'recommended',
			'text' => __( 'Recommended', 'ftc-product-ui' ),
		);
	}

	if ( $slug === 'cad' ) {
		return array(
			'type' => 'coming-soon',
			'text' => __( 'Coming Soon', 'ftc-product-ui' ),
		);
	}

	return null;
}
?>
