<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );

?>

<?php if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>
<div class="row py-5">
	<div class="col-sm-8">
		<?php the_content(); ?>
<?php// do_action( 'woocommerce_product_additional_information', $product ); ?>
<h3>Specifications</h3>
<?php 

/* hook: ft_display_product_specs provide array of args to make the specs table
*
* product:  product ID
* attribute_list array of desired attribute slugs, will use all visible attributes if not supplied
* table_head : the title of the table output
  */

$general = array( 'target-diameter', 'magnets', 'max-dc-power', 'max-rf-power', 'cathode-voltage-v', 'max-discharge-current', 'pressure-range-mtorr', 'water-flow-rate', 'min-cf-flange-size' );

do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $general, 'table_head' => 'General Specifications' ) );


?>
	</div>
                <div class="col-sm-4">
                  <?php the_post_thumbnail( 'full' ); ?>
                </div>
</div>



<div class="row py-5">
	<div class="col-sm-4">
		<h3>Dimensions</h3>
<?php 

$specifications = array('dimension', 'a', 'b', 'b-2', 'c', 'd', 'd-2', 'e','f' );

do_action( 'ft_display_product_specs', array( 'product' => $product , 'attribute_list' => $specifications, 'table_head' => 'Dimensional Specifications' ) );

 ?>
	</div>
	<div class="col-sm-8" style="display: flex; align-items: center; justify-content: center;">
		<?php
		    $attachment_ids = $product->get_gallery_image_ids();

		    foreach( $attachment_ids as $attachment_id ) {
		    	?>
		    	<div class="prod-img">
			    	<img src="<?php echo $image_link = wp_get_attachment_image_url( $attachment_id ,'full' ); ?>" />
			    </div>
		    	<?php
		        
		    }

			 ?>
	</div>
</div>



