<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$cat_head = "";
  global $post;
  $terms = get_the_terms( $post->ID, 'product_cat' );
  foreach ($terms as $term) {
      $cat_head = $term->name;
      $cat_slug = $term->slug;
      break;
  }  

?><!--
Product Detail Page Heading
AQUA-LOK Cryogenic Water Pumps
Vari-Q Throttle Valves
MAK Sputter Deposition Sources
e-Vap® E-Beam Evaporation Products
Re-Vap® Resistive Evaporation Sources
HTR Substrate Heater
Ferrotec MeiVac Power Supplies
Ferrotec MeiVac Monitors & Controllers
-->
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
<header class="page-header">
			<div class="page-banner">
				<div class="container">
					<div class="background-product"></div>
					<div class="flex-area-center">
													<h1><?php echo $cat_head; 	?></h1>
											</div>
				</div>
			</div>
	</header>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	//do_action( 'woocommerce_before_single_product_summary' );
	?>
	<div class="container">
<?php
if ( function_exists('yoast_breadcrumb') ) {
  yoast_breadcrumb( '<p class="meivac-breadcrumb" id="breadcrumbs">','</p>' );
}
?>
<?php if ($cat_slug=="end-of-life") : ?>
<div class="row">
   <div class="col-sm-9">
      <h2>NOTE: This product is no longer being sold and might not be supported. 
         Contact your sales representative to learn:
      </h2>
      <ul class="bulletlist">
         <li>End-of-sale and end-of-life dates</li>
         <li>What replacement products are available</li>
         <li>Information about product support</li>
      </ul>
   </div>
</div>
<?php endif; ?>
		<!--div class="summary entry-summary"-->
													<?php the_title('<h2>', '</h2>'); ?>
			<?php
			echo '<p class="product-title">Part Number: ' . $product->get_sku() . '</p>';
			add_action( 'ferrotec_product_tabs', 'woocommerce_output_product_data_tabs', 10 );
			do_action( 'ferrotec_product_tabs' );
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			//do_action( 'woocommerce_single_product_summary' );
			?>
		<!--/div-->
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	//do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
