<?php
/**
 * Ordering Information Tab Template
 *
 * Displays ordering information, part numbers, and purchase options.
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

// Get ordering information from ACF
$ordering_info = get_field( 'product_ordering_info', $product_id );
$part_number = get_field( 'product_model', $product_id );
$lead_time = get_field( 'product_lead_time', $product_id );
$min_order_qty = get_field( 'product_min_order_quantity', $product_id );
$quote_required = get_field( 'product_quote_required', $product_id );

// Check if product is purchasable
$is_purchasable = $product->is_purchasable();
$is_in_stock = $product->is_in_stock();
?>

<div class="ftc-ordering-tab">

	<?php if ( $part_number ) : ?>
		<div class="ftc-part-number">
			<h3><?php esc_html_e( 'Part Number', 'ftc-product-ui' ); ?></h3>
			<p class="ftc-part-number-value"><strong><?php echo esc_html( $part_number ); ?></strong></p>
		</div>
	<?php endif; ?>

	<?php if ( $is_purchasable && ! $quote_required ) : ?>
		<div class="ftc-purchase-section">
			<h3><?php esc_html_e( 'Purchase Options', 'ftc-product-ui' ); ?></h3>

			<?php if ( $is_in_stock ) : ?>
				<p class="ftc-stock-status in-stock">
					<span class="dashicons dashicons-yes-alt"></span>
					<?php esc_html_e( 'In Stock', 'ftc-product-ui' ); ?>
				</p>
			<?php else : ?>
				<p class="ftc-stock-status out-of-stock">
					<span class="dashicons dashicons-warning"></span>
					<?php esc_html_e( 'Currently Out of Stock', 'ftc-product-ui' ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $lead_time ) : ?>
				<p class="ftc-lead-time">
					<strong><?php esc_html_e( 'Lead Time:', 'ftc-product-ui' ); ?></strong>
					<?php echo esc_html( $lead_time ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $min_order_qty ) : ?>
				<p class="ftc-min-order-qty">
					<strong><?php esc_html_e( 'Minimum Order Quantity:', 'ftc-product-ui' ); ?></strong>
					<?php echo esc_html( $min_order_qty ); ?>
				</p>
			<?php endif; ?>

			<div class="ftc-add-to-cart">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
		</div>

	<?php elseif ( $quote_required || ! $is_purchasable ) : ?>
		<div class="ftc-quote-section">
			<h3><?php esc_html_e( 'Request a Quote', 'ftc-product-ui' ); ?></h3>
			<p><?php esc_html_e( 'This product requires a custom quote. Please contact us for pricing and availability.', 'ftc-product-ui' ); ?></p>

			<div class="ftc-contact-options">
				<a href="<?php echo esc_url( site_url( '/contact' ) ); ?>" class="button btn btn-primary ftc-quote-button">
					<?php esc_html_e( 'Request Quote', 'ftc-product-ui' ); ?>
				</a>

				<?php
				$phone = get_option( 'ftc_contact_phone', '1-800-000-0000' );
				$email = get_option( 'ftc_contact_email', 'sales@ferrotec.com' );
				?>

				<div class="ftc-contact-info">
					<p>
						<strong><?php esc_html_e( 'Phone:', 'ftc-product-ui' ); ?></strong>
						<a href="tel:<?php echo esc_attr( str_replace( array( '-', ' ', '(', ')' ), '', $phone ) ); ?>">
							<?php echo esc_html( $phone ); ?>
						</a>
					</p>
					<p>
						<strong><?php esc_html_e( 'Email:', 'ftc-product-ui' ); ?></strong>
						<a href="mailto:<?php echo esc_attr( $email ); ?>?subject=Quote Request: <?php echo esc_attr( get_the_title( $product_id ) ); ?>">
							<?php echo esc_html( $email ); ?>
						</a>
					</p>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $ordering_info ) : ?>
		<div class="ftc-ordering-info">
			<h3><?php esc_html_e( 'Ordering Information', 'ftc-product-ui' ); ?></h3>
			<div class="ftc-ordering-content">
				<?php echo wp_kses_post( $ordering_info ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	// Show related products for cross-selling
	$related_ids = wc_get_related_products( $product_id, 4 );
	if ( ! empty( $related_ids ) ) :
	?>
		<div class="ftc-related-products">
			<h3><?php esc_html_e( 'Related Products', 'ftc-product-ui' ); ?></h3>
			<div class="ftc-related-products-grid">
				<?php
				$related_products = array_map( 'wc_get_product', $related_ids );
				foreach ( $related_products as $related_product ) :
					if ( ! $related_product ) continue;
				?>
					<div class="ftc-related-product-item">
						<a href="<?php echo esc_url( $related_product->get_permalink() ); ?>">
							<?php echo $related_product->get_image( 'thumbnail' ); ?>
							<h4><?php echo esc_html( $related_product->get_name() ); ?></h4>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

</div>
