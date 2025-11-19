<?php
/**
 * Downloads Tab Template
 *
 * Displays downloadable files (datasheets, CAD files, manuals, etc.).
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

// Get downloadable files from ACF
$datasheet = get_field( 'product_datasheet', $product_id );
$cad_file = get_field( 'product_cad_file', $product_id );
$drawing = get_field( 'product_drawing', $product_id );
$manual = get_field( 'product_manual', $product_id );
$certificate = get_field( 'product_certificate', $product_id );
$additional_files = get_field( 'product_additional_files', $product_id );

// Helper function to render file download link
function ftc_render_file_link( $file, $label, $icon = 'pdf' ) {
	if ( ! $file ) {
		return;
	}

	$file_url = is_array( $file ) ? $file['url'] : $file;
	$file_title = is_array( $file ) && isset( $file['title'] ) ? $file['title'] : $label;
	$file_size = is_array( $file ) && isset( $file['filesize'] ) ? size_format( $file['filesize'] ) : '';

	?>
	<div class="ftc-download-item">
		<span class="ftc-file-icon dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span>
		<div class="ftc-file-info">
			<a href="<?php echo esc_url( $file_url ); ?>" target="_blank" rel="noopener" class="ftc-file-link">
				<strong><?php echo esc_html( $file_title ); ?></strong>
			</a>
			<?php if ( $file_size ) : ?>
				<span class="ftc-file-size">(<?php echo esc_html( $file_size ); ?>)</span>
			<?php endif; ?>
		</div>
		<a href="<?php echo esc_url( $file_url ); ?>" download class="button btn btn-sm btn-outline-primary ftc-download-button">
			<?php esc_html_e( 'Download', 'ftc-product-ui' ); ?>
		</a>
	</div>
	<?php
}
?>

<div class="ftc-downloads-tab">

	<div class="ftc-downloads-list">

		<?php if ( $datasheet ) : ?>
			<div class="ftc-download-section">
				<h3><?php esc_html_e( 'Product Datasheet', 'ftc-product-ui' ); ?></h3>
				<?php ftc_render_file_link( $datasheet, __( 'Technical Datasheet', 'ftc-product-ui' ), 'media-document' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $cad_file ) : ?>
			<div class="ftc-download-section">
				<h3><?php esc_html_e( 'CAD Files', 'ftc-product-ui' ); ?></h3>
				<?php ftc_render_file_link( $cad_file, __( 'CAD File (STEP/STP)', 'ftc-product-ui' ), 'download' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $drawing ) : ?>
			<div class="ftc-download-section">
				<h3><?php esc_html_e( 'Technical Drawings', 'ftc-product-ui' ); ?></h3>
				<?php ftc_render_file_link( $drawing, __( 'Technical Drawing', 'ftc-product-ui' ), 'format-image' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $manual ) : ?>
			<div class="ftc-download-section">
				<h3><?php esc_html_e( 'User Manual', 'ftc-product-ui' ); ?></h3>
				<?php ftc_render_file_link( $manual, __( 'User Manual', 'ftc-product-ui' ), 'book' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $certificate ) : ?>
			<div class="ftc-download-section">
				<h3><?php esc_html_e( 'Certificates', 'ftc-product-ui' ); ?></h3>
				<?php ftc_render_file_link( $certificate, __( 'Certificate of Compliance', 'ftc-product-ui' ), 'awards' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $additional_files && is_array( $additional_files ) ) : ?>
			<div class="ftc-download-section">
				<h3><?php esc_html_e( 'Additional Files', 'ftc-product-ui' ); ?></h3>
				<?php foreach ( $additional_files as $file ) : ?>
					<?php ftc_render_file_link( $file, __( 'Additional File', 'ftc-product-ui' ), 'media-default' ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php
		// Check if WooCommerce has downloadable files
		$wc_downloads = $product->get_downloads();
		if ( ! empty( $wc_downloads ) ) :
		?>
			<div class="ftc-download-section">
				<h3><?php esc_html_e( 'Product Downloads', 'ftc-product-ui' ); ?></h3>
				<?php foreach ( $wc_downloads as $download ) : ?>
					<?php
					ftc_render_file_link(
						$download->get_file(),
						$download->get_name(),
						'download'
					);
					?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php
		// If no files available
		if ( ! $datasheet && ! $cad_file && ! $drawing && ! $manual && ! $certificate && empty( $additional_files ) && empty( $wc_downloads ) ) :
		?>
			<div class="ftc-no-downloads">
				<p><?php esc_html_e( 'No downloadable files are currently available for this product.', 'ftc-product-ui' ); ?></p>
				<p><?php esc_html_e( 'Please contact us if you need technical documentation.', 'ftc-product-ui' ); ?></p>
			</div>
		<?php endif; ?>

	</div>

</div>
