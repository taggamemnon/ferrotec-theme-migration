<?php
/**
 * Specifications Tab Template
 *
 * Displays technical specifications from ACF fields and WooCommerce attributes.
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product ) {
	return;
}

// Detect product type
$product_id = $product->get_id();
$is_thermal = has_term( array( 'thermal-modules', 'peltier-coolers' ), 'product_cat', $product_id );
$is_seal = has_term( array( 'vacuum-feedthrough', 'ferrofluidic-seals' ), 'product_cat', $product_id );
$is_ferrofluid = has_term( array( 'ferrofluid' ), 'product_cat', $product_id );
$is_meivac = has_term( array( 'meivac' ), 'product_cat', $product_id );
?>

<div class="ftc-specs-tab">

	<?php if ( $is_thermal ) : ?>
		<?php
		// Thermal Electric Products
		$imax = get_field( 'thermal_current_max', $product_id );
		$vmax = get_field( 'thermal_voltage_max', $product_id );
		$tmax = get_field( 'thermal_delta_t_max', $product_id );
		$qcmax = get_field( 'thermal_cooling_capacity_max', $product_id );
		$base_w = get_field( 'thermal_base_width', $product_id );
		$base_l = get_field( 'thermal_base_length', $product_id );
		$top_w = get_field( 'thermal_top_width', $product_id );
		$top_l = get_field( 'thermal_top_length', $product_id );
		$height = get_field( 'thermal_height', $product_id );
		?>

		<!-- Electrical & Thermal Performance -->
		<h3><?php esc_html_e( 'Electrical &amp; Thermal Performance', 'ftc-product-ui' ); ?></h3>
		<table class="ftc-specs-table">
			<tbody>
				<?php if ( $imax ) : ?>
				<tr>
					<th><?php esc_html_e( 'Maximum Current (Imax)', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $imax ); ?> A</td>
				</tr>
				<?php endif; ?>

				<?php if ( $vmax ) : ?>
				<tr>
					<th><?php esc_html_e( 'Maximum Voltage (Vmax)', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $vmax ); ?> V</td>
				</tr>
				<?php endif; ?>

				<?php if ( $tmax ) : ?>
				<tr>
					<th><?php esc_html_e( 'Maximum Temperature Difference (ΔTmax)', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $tmax ); ?> °C</td>
				</tr>
				<?php endif; ?>

				<?php if ( $qcmax ) : ?>
				<tr>
					<th><?php esc_html_e( 'Maximum Cooling Capacity (Qcmax)', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $qcmax ); ?> W</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>

		<!-- Dimensions -->
		<?php if ( $base_w || $base_l || $top_w || $top_l || $height ) : ?>
		<h3><?php esc_html_e( 'Dimensions', 'ftc-product-ui' ); ?></h3>
		<table class="ftc-specs-table">
			<tbody>
				<?php if ( $base_w ) : ?>
				<tr>
					<th><?php esc_html_e( 'Base Width', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $base_w ); ?> mm</td>
				</tr>
				<?php endif; ?>

				<?php if ( $base_l ) : ?>
				<tr>
					<th><?php esc_html_e( 'Base Length', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $base_l ); ?> mm</td>
				</tr>
				<?php endif; ?>

				<?php if ( $top_w ) : ?>
				<tr>
					<th><?php esc_html_e( 'Top Width', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $top_w ); ?> mm</td>
				</tr>
				<?php endif; ?>

				<?php if ( $top_l ) : ?>
				<tr>
					<th><?php esc_html_e( 'Top Length', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $top_l ); ?> mm</td>
				</tr>
				<?php endif; ?>

				<?php if ( $height ) : ?>
				<tr>
					<th><?php esc_html_e( 'Height', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $height ); ?> mm</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		<?php endif; ?>

	<?php elseif ( $is_seal ) : ?>
		<?php
		// Vacuum Seal/Feedthrough Products
		$shaft_type = get_field( 'seal_shaft_type', $product_id );
		$mounting = get_field( 'seal_mount_type', $product_id );
		$environment = get_field( 'seal_environment', $product_id );
		$temperature = get_field( 'seal_temperature', $product_id );
		?>

		<h3><?php esc_html_e( 'Product Specifications', 'ftc-product-ui' ); ?></h3>
		<table class="ftc-specs-table">
			<tbody>
				<?php if ( $shaft_type ) : ?>
				<tr>
					<th><?php esc_html_e( 'Shaft Type', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $shaft_type ); ?></td>
				</tr>
				<?php endif; ?>

				<?php if ( $mounting ) : ?>
				<tr>
					<th><?php esc_html_e( 'Mounting', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $mounting ); ?></td>
				</tr>
				<?php endif; ?>

				<?php if ( $environment ) : ?>
				<tr>
					<th><?php esc_html_e( 'Environment', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $environment ); ?></td>
				</tr>
				<?php endif; ?>

				<?php if ( $temperature ) : ?>
				<tr>
					<th><?php esc_html_e( 'Temperature Range', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $temperature ); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>

	<?php elseif ( $is_ferrofluid ) : ?>
		<?php
		// Ferrofluid Products
		$sat_gauss = get_field( 'ferrofluid_saturation_gauss', $product_id );
		$sat_mt = get_field( 'ferrofluid_saturation_mt', $product_id );
		$viscosity_cp = get_field( 'ferrofluid_viscosity_cp', $product_id );
		$viscosity_mpa = get_field( 'ferrofluid_viscosity_mpa', $product_id );
		$density = get_field( 'ferrofluid_density_gml', $product_id );
		$flash_point = get_field( 'ferrofluid_flash_point', $product_id );
		?>

		<h3><?php esc_html_e( 'Magnetic Properties', 'ftc-product-ui' ); ?></h3>
		<table class="ftc-specs-table">
			<tbody>
				<?php if ( $sat_gauss ) : ?>
				<tr>
					<th><?php esc_html_e( 'Saturation Magnetization', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $sat_gauss ); ?> Gauss</td>
				</tr>
				<?php endif; ?>

				<?php if ( $sat_mt ) : ?>
				<tr>
					<th><?php esc_html_e( 'Saturation Magnetization', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $sat_mt ); ?> mT</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>

		<h3><?php esc_html_e( 'Physical Properties', 'ftc-product-ui' ); ?></h3>
		<table class="ftc-specs-table">
			<tbody>
				<?php if ( $viscosity_cp ) : ?>
				<tr>
					<th><?php esc_html_e( 'Viscosity @ 27°C', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $viscosity_cp ); ?> cP</td>
				</tr>
				<?php endif; ?>

				<?php if ( $viscosity_mpa ) : ?>
				<tr>
					<th><?php esc_html_e( 'Viscosity @ 27°C', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $viscosity_mpa ); ?> mPa·s</td>
				</tr>
				<?php endif; ?>

				<?php if ( $density ) : ?>
				<tr>
					<th><?php esc_html_e( 'Density', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $density ); ?> g/mL</td>
				</tr>
				<?php endif; ?>

				<?php if ( $flash_point ) : ?>
				<tr>
					<th><?php esc_html_e( 'Flash Point', 'ftc-product-ui' ); ?></th>
					<td><?php echo esc_html( $flash_point ); ?> °C</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>

	<?php endif; ?>

	<!-- Product Characteristics from WooCommerce Attributes -->
	<?php
	$attributes = $product->get_attributes();
	if ( ! empty( $attributes ) ) :
	?>
		<h3><?php esc_html_e( 'Product Characteristics', 'ftc-product-ui' ); ?></h3>
		<table class="ftc-specs-table">
			<tbody>
				<?php foreach ( $attributes as $attribute ) : ?>
					<?php if ( ! $attribute->get_visible() ) continue; ?>
					<tr>
						<th><?php echo esc_html( wc_attribute_label( $attribute->get_name() ) ); ?></th>
						<td><?php echo wp_kses_post( $product->get_attribute( $attribute->get_name() ) ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>

	<!-- Additional Product Information -->
	<?php
	$additional_info = get_field( 'product_additional_specs', $product_id );
	if ( $additional_info ) :
	?>
		<h3><?php esc_html_e( 'Additional Information', 'ftc-product-ui' ); ?></h3>
		<div class="ftc-additional-info">
			<?php echo wp_kses_post( $additional_info ); ?>
		</div>
	<?php endif; ?>

</div>
