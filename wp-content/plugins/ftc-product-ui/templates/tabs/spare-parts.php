<?php
/**
 * Spare Parts Tab Template (Seals Products Only)
 *
 * Displays available spare parts and replacement components.
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

$product_id = $product->get_id();

// Get spare parts data from ACF repeater
$spare_parts = get_field( 'seal_spare_parts', $product_id );
$spare_parts_intro = get_field( 'seal_spare_parts_intro', $product_id );
?>

<div class="ftc-spare-parts-tab">

	<?php if ( $spare_parts_intro ) : ?>
		<div class="ftc-spare-parts-intro">
			<?php echo wp_kses_post( $spare_parts_intro ); ?>
		</div>
	<?php endif; ?>

	<?php if ( $spare_parts && is_array( $spare_parts ) ) : ?>
		<div class="ftc-spare-parts-list">
			<h3><?php esc_html_e( 'Available Spare Parts', 'ftc-product-ui' ); ?></h3>

			<table class="ftc-spare-parts-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Part Number', 'ftc-product-ui' ); ?></th>
						<th><?php esc_html_e( 'Description', 'ftc-product-ui' ); ?></th>
						<th><?php esc_html_e( 'Quantity', 'ftc-product-ui' ); ?></th>
						<th><?php esc_html_e( 'Action', 'ftc-product-ui' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $spare_parts as $part ) : ?>
						<?php
						$part_number = isset( $part['part_number'] ) ? $part['part_number'] : '';
						$part_description = isset( $part['description'] ) ? $part['description'] : '';
						$part_quantity = isset( $part['quantity'] ) ? $part['quantity'] : '1';
						$part_product_id = isset( $part['linked_product'] ) ? $part['linked_product'] : null;
						?>
						<tr>
							<td><strong><?php echo esc_html( $part_number ); ?></strong></td>
							<td><?php echo esc_html( $part_description ); ?></td>
							<td><?php echo esc_html( $part_quantity ); ?></td>
							<td>
								<?php if ( $part_product_id ) : ?>
									<?php
									$part_product = wc_get_product( $part_product_id );
									if ( $part_product && $part_product->is_purchasable() ) :
									?>
										<a href="<?php echo esc_url( $part_product->add_to_cart_url() ); ?>" class="button btn btn-sm btn-primary">
											<?php esc_html_e( 'Add to Cart', 'ftc-product-ui' ); ?>
										</a>
									<?php else : ?>
										<a href="<?php echo esc_url( site_url( '/contact' ) ); ?>" class="button btn btn-sm btn-outline-primary">
											<?php esc_html_e( 'Request Quote', 'ftc-product-ui' ); ?>
										</a>
									<?php endif; ?>
								<?php else : ?>
									<a href="<?php echo esc_url( site_url( '/contact' ) ); ?>" class="button btn btn-sm btn-outline-primary">
										<?php esc_html_e( 'Request Quote', 'ftc-product-ui' ); ?>
									</a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

	<?php else : ?>
		<div class="ftc-no-spare-parts">
			<p><?php esc_html_e( 'No spare parts information is currently available for this product.', 'ftc-product-ui' ); ?></p>
			<p>
				<?php esc_html_e( 'For spare parts inquiries, please ', 'ftc-product-ui' ); ?>
				<a href="<?php echo esc_url( site_url( '/contact' ) ); ?>"><?php esc_html_e( 'contact us', 'ftc-product-ui' ); ?></a>.
			</p>
		</div>
	<?php endif; ?>

	<div class="ftc-spare-parts-note">
		<p class="ftc-note-text">
			<span class="dashicons dashicons-info"></span>
			<?php esc_html_e( 'Note: Spare parts availability may vary. Contact us for current stock and pricing.', 'ftc-product-ui' ); ?>
		</p>
	</div>

</div>
