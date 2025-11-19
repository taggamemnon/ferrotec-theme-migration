<?php
/**
 * Features Tab Template
 *
 * Displays product features and benefits.
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

// Get features content from ACF
$features_content = get_field( 'product_features', $product_id );
$benefits_content = get_field( 'product_benefits', $product_id );
$applications_content = get_field( 'product_applications', $product_id );

// Check for product-type specific features
$is_thermal = has_term( array( 'thermal-modules', 'peltier-coolers' ), 'product_cat', $product_id );
$is_seal = has_term( array( 'vacuum-feedthrough', 'ferrofluidic-seals' ), 'product_cat', $product_id );

if ( $is_seal ) {
	// Seal-specific features
	$seal_features = get_field( 'seal_features', $product_id );
	$seal_support = get_field( 'seal_support_bearings', $product_id );
}
?>

<div class="ftc-features-tab">

	<?php if ( $features_content ) : ?>
		<div class="ftc-features-section">
			<h3><?php esc_html_e( 'Features', 'ftc-product-ui' ); ?></h3>
			<div class="ftc-features-content">
				<?php echo wp_kses_post( $features_content ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $benefits_content ) : ?>
		<div class="ftc-benefits-section">
			<h3><?php esc_html_e( 'Benefits', 'ftc-product-ui' ); ?></h3>
			<div class="ftc-benefits-content">
				<?php echo wp_kses_post( $benefits_content ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $is_seal && isset( $seal_features ) && $seal_features ) : ?>
		<div class="ftc-seal-features-section">
			<h3><?php esc_html_e( 'Seal Features', 'ftc-product-ui' ); ?></h3>
			<div class="ftc-seal-features-content">
				<?php echo wp_kses_post( $seal_features ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $is_seal && isset( $seal_support ) && $seal_support ) : ?>
		<div class="ftc-seal-support-section">
			<h3><?php esc_html_e( 'Support Bearings', 'ftc-product-ui' ); ?></h3>
			<div class="ftc-seal-support-content">
				<?php echo wp_kses_post( $seal_support ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $applications_content ) : ?>
		<div class="ftc-applications-section">
			<h3><?php esc_html_e( 'Applications', 'ftc-product-ui' ); ?></h3>
			<div class="ftc-applications-content">
				<?php echo wp_kses_post( $applications_content ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	// Fallback: If no ACF content, show WooCommerce description
	if ( ! $features_content && ! $benefits_content && ! $applications_content ) :
		$description = $product->get_description();
		if ( $description ) :
	?>
		<div class="ftc-description-fallback">
			<?php echo wp_kses_post( $description ); ?>
		</div>
	<?php
		else :
	?>
		<div class="ftc-no-features">
			<p><?php esc_html_e( 'No features information available for this product.', 'ftc-product-ui' ); ?></p>
		</div>
	<?php
		endif;
	endif;
	?>

</div>
