<?php
/**
 * Network Settings Page (Multisite)
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 *
 * @var array $sites All sites in the network
 * @var array $available_tabs Available tabs
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap ftc-admin-wrap ftc-network-wrap">
	<h1 class="ftc-admin-title">
		<?php echo esc_html( get_admin_page_title() ); ?>
		<span class="ftc-network-badge"><?php esc_html_e( 'Network Admin', 'ftc-product-ui' ); ?></span>
	</h1>

	<p class="description">
		<?php esc_html_e( 'Manage feature flags across all sites in the network. Each site can be configured independently.', 'ftc-product-ui' ); ?>
	</p>

	<?php if ( isset( $_GET['updated'] ) ) : ?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Settings saved successfully!', 'ftc-product-ui' ); ?></p>
		</div>
	<?php endif; ?>

	<div class="ftc-network-sites">
		<?php foreach ( $sites as $site ) : ?>
			<?php
			switch_to_blog( $site->blog_id );
			$site_name = get_bloginfo( 'name' );
			$site_url = get_site_url();
			$domain = parse_url( $site_url, PHP_URL_HOST );
			$current_tabs = get_option( 'ftc_tabs', FTC_Feature_Flags::get_default_tabs() );
			$enabled_count = count( array_filter( $current_tabs ) );
			restore_current_blog();
			?>

			<div class="ftc-card ftc-site-card">
				<div class="ftc-card-header">
					<h3>
						<span class="dashicons dashicons-admin-site-alt3"></span>
						<?php echo esc_html( $site_name ); ?>
					</h3>
					<p class="ftc-site-domain"><?php echo esc_html( $domain ); ?></p>
				</div>

				<div class="ftc-card-body">
					<div class="ftc-site-stats">
						<div class="ftc-stat-item">
							<strong><?php echo esc_html( $enabled_count ); ?></strong> / <?php echo esc_html( count( $available_tabs ) ); ?>
							<?php esc_html_e( 'tabs enabled', 'ftc-product-ui' ); ?>
						</div>
					</div>

					<div class="ftc-enabled-tabs">
						<?php foreach ( $available_tabs as $slug => $label ) : ?>
							<?php if ( isset( $current_tabs[ $slug ] ) && $current_tabs[ $slug ] ) : ?>
								<span class="ftc-tab-badge ftc-tab-enabled">
									<span class="dashicons dashicons-yes"></span>
									<?php echo esc_html( $label ); ?>
								</span>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="ftc-card-footer">
					<?php
					$admin_url = is_multisite()
						? get_admin_url( $site->blog_id, 'admin.php?page=ftc-product-ui' )
						: admin_url( 'admin.php?page=ftc-product-ui' );
					?>
					<a href="<?php echo esc_url( $admin_url ); ?>" class="button button-primary">
						<?php esc_html_e( 'Configure', 'ftc-product-ui' ); ?>
					</a>
					<a href="<?php echo esc_url( $site_url ); ?>" class="button button-secondary" target="_blank">
						<?php esc_html_e( 'View Site', 'ftc-product-ui' ); ?>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="ftc-network-summary">
		<div class="ftc-card">
			<div class="ftc-card-header">
				<h3><?php esc_html_e( 'Network Summary', 'ftc-product-ui' ); ?></h3>
			</div>
			<div class="ftc-card-body">
				<table class="widefat ftc-summary-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Tab', 'ftc-product-ui' ); ?></th>
							<th><?php esc_html_e( 'Sites Using', 'ftc-product-ui' ); ?></th>
							<th><?php esc_html_e( 'Percentage', 'ftc-product-ui' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tab_usage = array();
						$total_sites = count( $sites );

						// Calculate usage
						foreach ( $available_tabs as $slug => $label ) {
							$count = 0;
							foreach ( $sites as $site ) {
								switch_to_blog( $site->blog_id );
								$tabs = get_option( 'ftc_tabs', array() );
								if ( isset( $tabs[ $slug ] ) && $tabs[ $slug ] ) {
									$count++;
								}
								restore_current_blog();
							}
							$tab_usage[ $slug ] = $count;
						}

						foreach ( $available_tabs as $slug => $label ) :
							$count = $tab_usage[ $slug ];
							$percentage = $total_sites > 0 ? round( ( $count / $total_sites ) * 100 ) : 0;
							?>
							<tr>
								<td><strong><?php echo esc_html( $label ); ?></strong></td>
								<td><?php echo esc_html( $count ); ?> / <?php echo esc_html( $total_sites ); ?></td>
								<td>
									<div class="ftc-progress-bar">
										<div class="ftc-progress-fill" style="width: <?php echo esc_attr( $percentage ); ?>%;"></div>
									</div>
									<span class="ftc-percentage"><?php echo esc_html( $percentage ); ?>%</span>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
